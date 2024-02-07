<nav class="navbar navbar-expand-lg navbar-light bg-gray-300 py-3 mt">
    <a class="navbar-brand ml-5" href="/">
        <img src="{{ asset('estimator_logo.png') }}" width="30" height="30" class="d-inline-block align-top" alt="">
        Estimator
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item ml-md-5 {{ Request::is('/') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('quotation_data.index') }}">Projects Estimations</a>
            </li>
            <li class="nav-item ml-md-3 {{ Request::is('estimations*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('quotation_data.form') }}">Create Estimation</a>
            </li>
        </ul>
    </div>
</nav>
