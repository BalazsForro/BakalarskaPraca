<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>ForróBcPráca - {{Request::path()}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <link rel="stylesheet" href="css/bootstrap-datepicker.min.css">
    <script src="js/bootstrap-datepicker.min.js"></script>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">ForróBcPráca</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class=" collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto ">
                <li class="nav-item">
                    <a class="nav-link mx-3 {{Request::path()=="aktualny" ? 'active' : ""}}" href="/aktualny">Aktuálne
                        údaje</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-3 {{Request::path()=="grafNapatia" ? 'active' : ""}}" href="/grafNapatia">Graf
                        napätia</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-3 {{Request::path()=="grafPrudu" ? 'active' : ""}}" href="/grafPrudu">Graf
                        prúdu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-3 {{Request::path()=="grafVýkonu" ? 'active' : ""}}" href="/grafVykonu">Graf
                        výkonu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-3 {{Request::path()=="grafSvetelnosti" ? 'active' : ""}}"
                       href="/grafSvetelnosti">Graf svetelnosti</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-3 {{Request::path()=="vsetky" ? 'active' : ""}}" href="/vsetky">Všetky
                        údaje</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<script>
    $.fn.datepicker.dates['en'] = {
        days: ["Nedeľa", "Pondelok", "Utorok", "Streda", "Štvrtok", "Piatok", "Sobota"],
        daysShort: ["Ned", "Pon", "Uto", "Str", "Štv", "Pia", "Sob"],
        daysMin: ["Ne", "Po", "Ut", "St", "Št", "Pia", "So"],
        months: ["Január", "Február", "Marec", "Apríl", "Máj", "Jún", "Júl", "August", "September", "Október", "November", "December"],
        monthsShort: ["Jan", "Feb", "Mar", "Apr", "Máj", "Jún", "Júl", "Aug", "Sep", "Okt", "Nov", "Dec"],
        today: "Dnes",
        clear: "Vymazať",
        format: "yyyy-mm-dd",
        titleFormat: "MM yyyy",
        weekStart: 1
    };
</script>
<div class="container mt-5 mb-5">
    @yield('body')
</div>
</body>
</html>
