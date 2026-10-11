<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'MiniCore Comisiones')</title>
    <style>
        :root { --bg:#f4f6fb; --card:#fff; --text:#1f2937; --muted:#6b7280; --primary:#2563eb; --border:#e5e7eb; --ok:#059669; --err:#dc2626; }
        * { box-sizing: border-box; }
        body { margin:0; font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif; background:var(--bg); color:var(--text); }
        header { background:var(--primary); color:#fff; padding:18px 16px; }
        header h1 { margin:0; font-size:1.4rem; }
        header p { margin:4px 0 0; opacity:.85; font-size:.9rem; }
        main { max-width:1000px; margin:24px auto; padding:0 16px; }
        .card { background:var(--card); border:1px solid var(--border); border-radius:10px; padding:20px; margin-bottom:20px; }
        .card h2 { margin-top:0; font-size:1.1rem; }
        form.filtro { display:flex; gap:12px; flex-wrap:wrap; align-items:flex-end; }
        label { display:flex; flex-direction:column; font-size:.85rem; color:var(--muted); gap:4px; }
        input[type=date] { padding:8px 10px; border:1px solid var(--border); border-radius:6px; font-size:1rem; }
        button, .btn { background:var(--primary); color:#fff; border:0; padding:10px 18px; border-radius:6px; font-size:.95rem; cursor:pointer; text-decoration:none; }
        .btn-sec { background:#e5e7eb; color:var(--text); }
        .tabla-wrap { overflow-x:auto; }
        table { width:100%; border-collapse:collapse; font-size:.92rem; }
        th, td { padding:10px; border-bottom:1px solid var(--border); text-align:left; white-space:nowrap; }
        th { background:#f9fafb; color:var(--muted); font-weight:600; }
        td.num, th.num { text-align:right; font-variant-numeric: tabular-nums; }
        tfoot td { font-weight:700; background:#f9fafb; }
        .comision { color:var(--ok); font-weight:600; }
        .errores { background:#fef2f2; border:1px solid #fecaca; color:var(--err); padding:10px 14px; border-radius:6px; margin-bottom:14px; }
        .muted { color:var(--muted); }
        .badge { display:inline-block; padding:2px 8px; border-radius:999px; background:#eff6ff; color:var(--primary); font-size:.8rem; }
    </style>
</head>
<body>
    <header>
        <h1>MiniCore · Cálculo de Comisiones</h1>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>
