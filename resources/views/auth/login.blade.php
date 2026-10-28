<x-layout title="Log in">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body p-4">
                    <h1 class="h4 mb-3">Log in</h1>

                    <form action="{{ route('login') }}" method="POST" novalidate>
                        @csrf
                        <x-input name="email" label="Email" type="email" autofocus />
                        <x-input name="password" label="Password" type="password" />

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Log in</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>