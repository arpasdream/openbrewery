<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Birrifici</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .brewery {
            margin-bottom: 10px;
        }

        .container {
            margin-top: 50px;
        }
    </style>
</head>

<body>
<div class="container">
    <h1 class="text-center mb-4">Birrifici</h1>

    <!-- Form di login -->
    <div class="row justify-content-center" id="show_form">
        <div class="col-md-6">
            <form onsubmit="handleLogin(event)" class="card p-4 shadow">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" class="form-control" placeholder="Inserisci il tuo username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" class="form-control" placeholder="Inserisci la tua password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Accedi</button>
            </form>
        </div>
    </div>

    <!-- Sezione per mostrare le birrerie -->
    <div id="breweries" class="mt-4">
        <!-- Le birrerie saranno aggiunte qui dinamicamente -->
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
    async function fetchBreweries(page = 1) {
        const token = localStorage.getItem('token');
        if (!token) {
            alert('Accedi per vedere le breweries');
            return;
        }

        const response = await fetch(`/api/breweries?page=${page}`, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json',
            },
        });

        if (response.ok) {
            const data = await response.json();
            renderBreweries(data);

            const show_form = document.getElementById('show_form');
            show_form.style.display = 'none'; // Nasconde il form
        } else {
            alert('Impossibile recuperare i birrifici');
        }
    }

    function renderBreweries(breweries) {
        const container = document.getElementById('breweries');
        container.innerHTML = ''; // Pulisci la lista precedente

        breweries.forEach(brewery => {
            const div = document.createElement('div');
            div.className = 'card mb-3';
            div.innerHTML = `
                    <div class="card-body">
                        <h5 class="card-title">${brewery.name}</h5>
                        <p class="card-text">${brewery.city}, ${brewery.state}</p>
                    </div>
                `;
            container.appendChild(div);
        });
    }

    function handleLogin(event) {
        event.preventDefault();
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        fetch('/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ username, password }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.token) {
                    localStorage.setItem('token', data.token);
                    alert('Accesso eseguito');
                    fetchBreweries();
                } else {
                    alert('Accesso fallito');
                }
            });
    }
</script>
</body>
</html>
