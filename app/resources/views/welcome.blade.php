<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GCS Projeto - {{ config('app.env') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #0f172a; color: #e2e8f0; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { background: #1e293b; border: 1px solid #334155; border-radius: 12px; padding: 48px; text-align: center; max-width: 480px; }
        h1 { font-size: 2rem; font-weight: 700; color: #38bdf8; margin-bottom: 8px; }
        .badge { display: inline-block; background: #0ea5e9; color: white; font-size: 0.75rem; font-weight: 600; padding: 4px 12px; border-radius: 999px; margin-bottom: 24px; text-transform: uppercase; letter-spacing: 1px; }
        p { color: #94a3b8; line-height: 1.6; }
        .endpoints { margin-top: 24px; text-align: left; background: #0f172a; border-radius: 8px; padding: 16px; }
        .endpoints h3 { font-size: 0.875rem; color: #64748b; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 1px; }
        .endpoint { display: flex; gap: 8px; margin-bottom: 8px; font-size: 0.875rem; }
        .method { background: #1d4ed8; color: white; padding: 2px 8px; border-radius: 4px; font-weight: 600; min-width: 50px; text-align: center; }
        .method.get { background: #15803d; }
        .method.post { background: #1d4ed8; }
        .method.put { background: #b45309; }
        .method.delete { background: #b91c1c; }
        code { color: #e2e8f0; font-family: monospace; }
    </style>
</head>
<body>
    <div class="card">
        <h1>GCS Projeto</h1>
        <span class="badge">{{ config('app.env') }}</span>
        <p>Pipeline CI/CD — Gerência de Configuração de Software 2026/A</p>
        <div class="endpoints">
            <h3>API Endpoints</h3>
            <div class="endpoint"><span class="method get">GET</span><code>/api/v1/produtos</code></div>
            <div class="endpoint"><span class="method post">POST</span><code>/api/v1/produtos</code></div>
            <div class="endpoint"><span class="method get">GET</span><code>/api/v1/produtos/{id}</code></div>
            <div class="endpoint"><span class="method put">PUT</span><code>/api/v1/produtos/{id}</code></div>
            <div class="endpoint"><span class="method delete">DELETE</span><code>/api/v1/produtos/{id}</code></div>
            <div class="endpoint"><span class="method get">GET</span><code>/api/health</code></div>
        </div>
    </div>
</body>
</html>
