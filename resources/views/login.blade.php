<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>

<body class="flex flex-grow flex-col w-full h-full dark:bg-gray-800">
    @auth
    @else
    <div class="flex flex-grow justify-center items-center flex-col">
        <span class="text-3xl font-extrabold mb-3 dark:text-gray-400">Verification Portal</span>
        <form action="/login" method="POST" class="bg-gray-100 dark:bg-gray-900 shadow-lg rounded px-8 pt-6 pb-8 mb-3">
            @csrf
            <div>
                <label class="block text-gray-700 dark:text-gray-400 text-sm font-bold mb-1">Username</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-400 leading-tight focus:outline-none focus:shadow-outline mb-2 dark:bg-gray-700"
                    name="loginName" type="text" placeholder="Name">
            </div>
            <div class="mb-3">
                <label class="block text-gray-700 dark:text-gray-400 text-sm font-bold mb-1">Password</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-400 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700"
                    name="loginPassword" type="password" placeholder="Password">
            </div>

            @if($errors->any())
            @foreach ($errors->all() as $error)
            <li class="text-red-700 text-xs">{{$error}}</li>
            @endforeach
            @endif
            @if(session()->has('message'))
            <div class="text-red-500 text-xs mt-3 flex flex-grow justify-center">{{session()->get('message')}}</div>
            @endif
            <div>
                <button
                    class="bg-accredify-700 hover:bg-accredify-500 text-white py-1 px-3 rounded-full mt-8 block mx-auto mb-3">
                    Login
                </button>
                <div class="flex flex-grow justify-center">
                    <a type=" button" class="bg-green-700 hover:bg-green-500 text-white py-1 px-3 rounded-full"
                        href="register">Register</a>
                </div>
            </div>
        </form>
        @include('footer')
    </div>
    @endauth
</body>

</html>