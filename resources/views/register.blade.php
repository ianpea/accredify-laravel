<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>

<body class="flex flex-grow flex-col w-full h-full dark:bg-gray-800">
    <div class="flex flex-grow justify-center items-center flex-col">
        <span class="text-3xl font-extrabold mb-3 dark:text-gray-400">Register</span>
        <form action="/register" method="POST"
            class="bg-gray-100 shadow-lg rounded px-8 pt-6 pb-8 mb-3 dark:bg-gray-900">
            @csrf
            <div>
                <label class="block text-gray-900 dark:text-gray-400 text-sm font-bold mb-1">Username</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 dark:text-gray-400 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2"
                    name="name" type="text" placeholder="Name">
            </div>
            <div>
                <label class="block text-gray-900 dark:text-gray-400 text-sm font-bold mb-1">Email</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 dark:text-gray-400 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2"
                    name="email" type="email" placeholder="Email">
            </div>
            <div>
                <label class="block text-gray-900 dark:text-gray-400 text-sm font-bold mb-1">Password</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 dark:text-gray-400 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    name="password" type="password" placeholder="Password">
            </div>
            @if($errors->any())
            <div class="text-red-500 text-xs mt-3">Verification failed with error(s):</div>
            @foreach ($errors->all() as $error)
            <li class="text-red-700 text-xs">{{$error}}</li>
            @endforeach
            @endif
            <div>
                <button
                    class="bg-green-700 hover:bg-green-500 text-white py-1 px-3 rounded-full mt-8 block mx-auto mb-1">
                    Register
                </button>
                <a class="text-blue-500 hover:text-blue-700 text-center text-xs py-1 px-3 rounded-full block mx-auto mb-3 mt-1"
                    href="/">
                    Already registered? Click here
                </a>
            </div>
        </form>
        @include('footer')
    </div>
</body>

</html>