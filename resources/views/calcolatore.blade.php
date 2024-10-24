<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calcolo del Fattore KXPO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1 class="my-4">Calcolo del Fattore KXPO</h1>

    <form id="kxpoForm">
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="lunghezza" class="form-label">Lunghezza della Nave (metri)</label>
                <input type="text" class="form-control" id="lunghezza" required>
            </div>

            <div class="col-md-12 mb-3">
                <label for="t_sc" class="form-label">Pescaggio a Pieno Carico (metri)</label>
                <input type="number" step="0.01" min="0.01" class="form-control" id="t_sc" required>
            </div>

            <div class="col-md-12 mb-3">
                <label for="vertical_shift" class="form-label">Posizione Verticale (metri)</label>
                <input type="number" step="0.0001" class="form-control" id="vertical_shift" required>
            </div>

            <div class="col-md-12 mb-3">
                <label for="cg_h" class="form-label">Altezza del Centro di Gravità (CG_h) (metri)</label>
                <input type="number" class="form-control" id="cg_h" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label for="pitch_angle_gradi" class="form-label">Angolo di Pitch (gradi)</label>
                <input type="number" step="0.0001" min="0.0001" class="form-control" id="pitch_angle_gradi" value="7.5" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label for="pitch_angle_radianti" class="form-label">Angolo di Pitch (radianti)</label>
                <input type="number" step="0.0001" min="0.0001" class="form-control" id="pitch_angle_radianti" readonly>
            </div>

            <div class="col-md-12 mb-3">
                <label for="angular_acceleration_pitch" class="form-label">Accelerazione Angolare Pitch (rad/s²)</label>
                <input type="number" step="0.0001" min="0.0001" class="form-control" id="angular_acceleration_pitch" value="0.105" readonly>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Calcola KXPO</button>
    </form>

    <table id="tabellaRisultato" class="mt-3">
        <thead>
        <tr>
            <th id="thTabella"></th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('pitch_angle_radianti').value =
            conversioneDaGradiARadianti(document.getElementById('pitch_angle_gradi').value).toFixed(4);
    });

    function conversioneDaGradiARadianti(valoreInGradi) {
        return valoreInGradi * (Math.PI / 180);
    }

    document.getElementById('kxpoForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const lunghezza = document.getElementById('lunghezza').value;
        const t_sc = document.getElementById('t_sc').value;
        const vertical_shift = document.getElementById('vertical_shift').value;

        axios.post('/api/calcola-kxpo', {
            lunghezza: lunghezza,
            t_sc: t_sc,
            vertical_shift: vertical_shift
        })
            .then(response => {
                document.getElementById('thTabella').innerText = 'Risultato del Calcolo KXPO';

                const row = document.createElement('tr');
                const cell = document.createElement('td');
                cell.innerHTML = '<span class="text-success">' + response.data.kxpo + '</span>';
                row.appendChild(cell);

                const tbody = document.getElementById('tabellaRisultato').querySelector('tbody');
                tbody.innerHTML = '';
                tbody.appendChild(row);

                document.getElementById('cg_h').value = response.data.cg_h;
            })
            .catch(error => {
                if (error.response.status === 422) {
                    const messaggiDiErrore = Object.keys(error.response.data.errori)
                        .flatMap(key => error.response.data.errori[key]);

                    document.getElementById('thTabella').innerText = 'Errore!';

                    const tbody = document.getElementById('tabellaRisultato').querySelector('tbody');
                    tbody.innerHTML = '';
                    messaggiDiErrore.forEach(message => {
                        const row = document.createElement('tr');
                        const cell = document.createElement('td');
                        cell.innerHTML = '<span class="text-danger">' + message + '</span>';
                        row.appendChild(cell);
                        tbody.appendChild(row);
                    });
                }
            });
    });
</script>
</body>
</html>
