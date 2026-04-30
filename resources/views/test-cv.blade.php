{{-- resources/views/test-cv.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test - Extraer texto de CV</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: system-ui, sans-serif; background: #f3f4f6; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1rem; }
        .card { background: #fff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,.08); padding: 2rem; max-width: 600px; width: 100%; }
        h1 { font-size: 1.25rem; margin-bottom: 1.5rem; color: #111827; }
        label { display: block; font-size: .875rem; font-weight: 500; color: #374151; margin-bottom: .5rem; }
        input[type="file"] { width: 100%; padding: .5rem; border: 2px dashed #d1d5db; border-radius: 8px; cursor: pointer; margin-bottom: 1rem; }
        button { background: #2563eb; color: #fff; border: none; padding: .625rem 1.25rem; border-radius: 8px; font-size: .875rem; cursor: pointer; }
        button:hover { background: #1d4ed8; }
        button:disabled { opacity: .5; cursor: not-allowed; }
        .result { margin-top: 1.5rem; }
        .result h2 { font-size: 1rem; margin-bottom: .5rem; color: #111827; }
        .result pre { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1rem; white-space: pre-wrap; word-break: break-word; max-height: 400px; overflow-y: auto; font-size: .8125rem; line-height: 1.6; }
        .error { color: #dc2626; font-size: .875rem; margin-top: 1rem; }
        .spinner { display: none; margin-left: .5rem; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Extraer texto de CV</h1>

        <form id="cvForm" enctype="multipart/form-data">
            @csrf
            <label for="cvFile">Seleccioná un archivo (PDF, DOC, DOCX)</label>
            <input type="file" name="cvFile" id="cvFile" accept=".pdf,.doc,.docx">
            <button type="submit" id="submitBtn">
                Enviar
                <span class="spinner" id="spinner">⏳</span>
            </button>
        </form>

        <div class="error" id="errorBox"></div>

        <div class="result" id="resultBox" style="display:none;">
            <h2>Texto extraído:</h2>
            <pre id="resultText"></pre>
        </div>
    </div>

    <script>
        const form      = document.getElementById('cvForm');
        const errorBox  = document.getElementById('errorBox');
        const resultBox = document.getElementById('resultBox');
        const resultTxt = document.getElementById('resultText');
        const submitBtn = document.getElementById('submitBtn');
        const spinner   = document.getElementById('spinner');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            errorBox.textContent = '';
            resultBox.style.display = 'none';
            submitBtn.disabled = true;
            spinner.style.display = 'inline';

            const formData = new FormData(form);

            try {
                const res = await fetch("{{ route('cv.extract') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': formData.get('_token'),
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                const data = await res.json();

                if (!res.ok) {
                    const msgs = data.errors
                        ? Object.values(data.errors).flat().join('\n')
                        : (data.message || 'Error desconocido');
                    errorBox.textContent = msgs;
                    return;
                }

                resultTxt.textContent = data.text;
                resultBox.style.display = 'block';

            } catch (err) {
                errorBox.textContent = 'Error de conexión: ' + err.message;
            } finally {
                submitBtn.disabled = false;
                spinner.style.display = 'none';
            }
        });
    </script>
</body>
</html>