<?php
/**
 * Mock payment gateway (instructor-owned). Behaves like a simplified PayMongo/Xendit.
 * It is a separate "external system": run it in its own terminal, next to the Laravel app.
 *
 *   php -S localhost:9000 mock-gateway/index.php
 *
 * API (needs header  Authorization: Bearer sk_test_mock)
 *   POST /v1/checkouts       JSON {amount, reference, success_url, cancel_url, webhook_url}
 *                            -> 201 {id, checkout_url, status}
 *   GET  /v1/checkouts/{id}  -> the checkout
 *
 * Pages
 *   GET  /                   dashboard: every checkout and webhook sent
 *   GET  /pay/{id}           the page the customer pays on (Pay / Fail buttons)
 *
 * Webhook sent to webhook_url after Pay or Fail:
 *   POST JSON {"type": "checkout.paid" | "checkout.failed", "data": {id, reference, amount, status}}
 *   Header X-Mock-Signature: hex HMAC-SHA256 of the raw JSON body, key = whsec_mock
 */

const API_SECRET = 'sk_test_mock';
const WEBHOOK_SECRET = 'whsec_mock';
const DATA_FILE = __DIR__.'/data.json';

function load(): array
{
    return is_file(DATA_FILE) ? json_decode(file_get_contents(DATA_FILE), true) : ['checkouts' => [], 'webhooks' => []];
}

function save(array $db): void
{
    file_put_contents(DATA_FILE, json_encode($db, JSON_PRETTY_PRINT));
}

function json_out(int $status, array $body): void
{
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($body);
}

function authorized(): bool
{
    $header = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

    return hash_equals('Bearer '.API_SECRET, $header);
}

function base_url(): string
{
    return 'http://'.($_SERVER['HTTP_HOST'] ?? 'localhost:9000');
}

function send_webhook(array &$db, array $checkout, string $type): void
{
    $body = json_encode([
        'type' => $type,
        'data' => [
            'id' => $checkout['id'],
            'reference' => $checkout['reference'],
            'amount' => $checkout['amount'],
            'status' => $checkout['status'],
        ],
    ]);
    $signature = hash_hmac('sha256', $body, WEBHOOK_SECRET);

    $context = stream_context_create(['http' => [
        'method' => 'POST',
        'header' => "Content-Type: application/json\r\nAccept: application/json\r\nX-Mock-Signature: {$signature}\r\n",
        'content' => $body,
        'timeout' => 10,
        'ignore_errors' => true,
    ]]);

    $response = @file_get_contents($checkout['webhook_url'], false, $context);
    $statusLine = $http_response_header[0] ?? 'no response (is the Laravel app running?)';

    $db['webhooks'][] = [
        'at' => date('Y-m-d H:i:s'),
        'checkout' => $checkout['id'],
        'type' => $type,
        'url' => $checkout['webhook_url'],
        'result' => $statusLine,
        'response' => $response === false ? null : substr($response, 0, 300),
    ];
}

$method = $_SERVER['REQUEST_METHOD'];
$path = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') ?: '/';
$db = load();

// --- API ---------------------------------------------------------------
if ($method === 'POST' && $path === '/v1/checkouts') {
    if (! authorized()) {
        json_out(401, ['error' => 'Invalid or missing API key']);
        return true;
    }

    $in = json_decode(file_get_contents('php://input'), true) ?: [];
    $missing = array_diff(['amount', 'reference', 'success_url', 'cancel_url', 'webhook_url'], array_keys($in));
    if ($missing || ! is_numeric($in['amount']) || $in['amount'] <= 0) {
        json_out(422, ['error' => 'Missing or invalid fields', 'fields' => array_values($missing)]);
        return true;
    }

    $id = 'cs_'.bin2hex(random_bytes(6));
    $db['checkouts'][$id] = [
        'id' => $id,
        'amount' => round((float) $in['amount'], 2),
        'reference' => (string) $in['reference'],
        'success_url' => $in['success_url'],
        'cancel_url' => $in['cancel_url'],
        'webhook_url' => $in['webhook_url'],
        'status' => 'open',
        'created_at' => date('Y-m-d H:i:s'),
    ];
    save($db);

    json_out(201, ['id' => $id, 'checkout_url' => base_url().'/pay/'.$id, 'status' => 'open']);
    return true;
}

if ($method === 'GET' && preg_match('#^/v1/checkouts/(cs_\w+)$#', $path, $m)) {
    if (! authorized()) {
        json_out(401, ['error' => 'Invalid or missing API key']);
        return true;
    }
    isset($db['checkouts'][$m[1]]) ? json_out(200, $db['checkouts'][$m[1]]) : json_out(404, ['error' => 'Not found']);
    return true;
}

// --- Customer payment page ---------------------------------------------
if (preg_match('#^/pay/(cs_\w+)(?:/(succeed|fail|resend))?$#', $path, $m)) {
    $checkout = $db['checkouts'][$m[1]] ?? null;
    if (! $checkout) {
        http_response_code(404);
        echo 'Checkout not found';
        return true;
    }

    if ($method === 'POST' && isset($m[2])) {
        if ($m[2] === 'resend') {
            send_webhook($db, $checkout, $checkout['status'] === 'paid' ? 'checkout.paid' : 'checkout.failed');
            save($db);
            header('Location: /');
            return true;
        }

        if ($checkout['status'] === 'open') {
            $checkout['status'] = $m[2] === 'succeed' ? 'paid' : 'failed';
            $db['checkouts'][$checkout['id']] = $checkout;
            send_webhook($db, $checkout, $checkout['status'] === 'paid' ? 'checkout.paid' : 'checkout.failed');
            save($db);
        }

        $target = $checkout['status'] === 'paid' ? $checkout['success_url'] : $checkout['cancel_url'];
        $target .= (str_contains($target, '?') ? '&' : '?').'checkout_id='.$checkout['id'];
        header('Location: '.$target);
        return true;
    }

    $amount = number_format($checkout['amount'], 2);
    $ref = htmlspecialchars($checkout['reference']);
    $open = $checkout['status'] === 'open';
    echo <<<HTML
<!DOCTYPE html><html><head><meta charset="utf-8"><title>MockPay</title>
<style>body{font-family:system-ui,sans-serif;background:#f3f4f6;display:flex;justify-content:center;padding-top:60px}
.card{background:#fff;padding:32px;border-radius:12px;width:360px;box-shadow:0 1px 4px #0002}
button{width:100%;padding:12px;border:0;border-radius:8px;font-size:16px;margin-top:10px;cursor:pointer}
.pay{background:#16a34a;color:#fff}.fail{background:#e5e7eb}</style></head><body><div class="card">
<p style="color:#6b7280;margin:0">MockPay · test mode</p>
<h2 style="margin:8px 0">PHP {$amount}</h2><p>Reference: {$ref}</p><p>Status: <b>{$checkout['status']}</b></p>
HTML;
    if ($open) {
        echo "<form method=post action=\"/pay/{$checkout['id']}/succeed\"><button class=pay>Pay with test GCash</button></form>";
        echo "<form method=post action=\"/pay/{$checkout['id']}/fail\"><button class=fail>Simulate failed payment</button></form>";
    }
    echo '</div></body></html>';
    return true;
}

// --- Dashboard ---------------------------------------------------------
if ($method === 'GET' && $path === '/') {
    echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>MockPay dashboard</title>';
    echo '<style>body{font-family:system-ui,sans-serif;padding:24px}table{border-collapse:collapse;width:100%;margin-bottom:32px}td,th{border:1px solid #ddd;padding:6px;font-size:13px;text-align:left}</style></head><body>';
    echo '<h1>MockPay dashboard</h1><h2>Checkouts</h2><table><tr><th>ID</th><th>Reference</th><th>Amount</th><th>Status</th><th>Created</th><th></th></tr>';
    foreach (array_reverse($db['checkouts']) as $c) {
        $resend = $c['status'] === 'open' ? '' : "<form method=post action=\"/pay/{$c['id']}/resend\"><button>Resend webhook</button></form>";
        echo '<tr><td><a href="/pay/'.$c['id'].'">'.$c['id'].'</a></td><td>'.htmlspecialchars($c['reference']).'</td><td>'.$c['amount'].'</td><td>'.$c['status'].'</td><td>'.$c['created_at'].'</td><td>'.$resend.'</td></tr>';
    }
    echo '</table><h2>Webhooks sent</h2><table><tr><th>Time</th><th>Checkout</th><th>Type</th><th>URL</th><th>Result</th><th>Response</th></tr>';
    foreach (array_reverse($db['webhooks']) as $w) {
        echo '<tr><td>'.$w['at'].'</td><td>'.$w['checkout'].'</td><td>'.$w['type'].'</td><td>'.htmlspecialchars($w['url']).'</td><td>'.htmlspecialchars($w['result']).'</td><td>'.htmlspecialchars((string) $w['response']).'</td></tr>';
    }
    echo '</table></body></html>';
    return true;
}

json_out(404, ['error' => 'Unknown endpoint']);
return true;
