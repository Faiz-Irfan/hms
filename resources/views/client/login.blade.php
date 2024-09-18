<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-50">
    <div class="container mx-auto  min-h-screen">
        <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                {{-- <img src="{{ asset('assets/img/tracknew.svg') }}" alt=""> --}}

                <img class="mx-auto h-full w-auto" src={{ asset('assets/img/tracknew.svg') }} alt="Your Company">
                <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-indigo-600">Sign in</h2>
            </div>
            <div class="flex items-top justify-center pt-5">
                <div class="card card-compact bg-base-100 w-96 shadow-md">
                    <div class="card-body">
                        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                            <form class="space-y-6" action="#" method="POST">
                                <div>
                                    <label for="email"
                                        class="block text-sm font-medium leading-6 text-gray-900">Email
                                        address</label>
                                    <div class="mt-2">
                                        <input id="email" name="email" type="email" autocomplete="email"
                                            required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div>
                                    <div class="flex items-center justify-between">
                                        <label for="password"
                                            class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                                        <div class="text-sm">
                                            <a href="#"
                                                class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot
                                                password?</a>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <input id="password" name="password" type="password"
                                            autocomplete="current-password" required
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div>
                                    <button type="submit"
                                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign
                                        in</button>
                                </div>
                            </form>

                            <p class="mt-10 text-center text-sm text-gray-500">
                                Not a member?
                                <a href="#" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500"
                                    data-bs-toggle="modal" data-bs-target="#registerModal">
                                    Register</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="registerModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Register</h2>
                <button class="text-gray-400 hover:text-gray-600" onclick="closeModal()">&times;</button>
            </div>
            <form action="{{ route('client.register') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="name" name="name" id="name" required
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                    @error('name')
                        <div role="alert" class="alert alert-error">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" required
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                    @error('email')
                        <div role="alert" class="alert alert-error">{{ $message }}</div>
                    @enderror
                </div>
                {{-- Matric Input --}}
                <div>
                    <label for="matric" class="block text-sm font-medium text-gray-700">Matric</label>
                    <input type="matric" name="matric" id="matric" required
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" required
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    {{-- <button
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"></button> --}}
                    <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-md font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
<script>
    // Function to close the modal
    function closeModal() {
        document.getElementById('registerModal').classList.add('hidden');
    }

    // Event listener to close the modal when clicking outside of it
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('registerModal');
        if (event.target === modal) {
            closeModal();
        }
    });

    // Show the modal when the button is clicked
    document.querySelector('[data-bs-toggle="modal"]').addEventListener('click', function() {
        document.getElementById('registerModal').classList.remove('hidden');
    });

    // Show the modal if there are validation errors
    @if ($errors->any())
        document.getElementById('registerModal').classList.remove('hidden');
    @endif
</script>
