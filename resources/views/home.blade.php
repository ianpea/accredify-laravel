<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    @vite('resources/css/app.css')
</head>

<body class="flex flex-grow flex-col w-full h-full dark:bg-gray-800">
    @auth
    <div class="flex flex-grow justify-center items-center flex-col">
        <span class="text-3xl font-extrabold mb-3 dark:text-gray-400">Welcome back, <b>{{Auth::user()->name}}</b></span>
        <form action="/verify" method="POST" enctype="multipart/form-data"
            class="bg-gray-100 dark:bg-gray-900 shadow-lg rounded px-8 pt-6 pb-8 mb-3">
            @csrf
            <div class="flex flex-grow justify-center">
                <label class="mb-4 text-lg dark:text-gray-400" style="display: block;" for="fileInput">Select a file to
                    verify</label>
            </div>
            <div>

                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="fileInput">Upload
                    file</label>
                <input
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                    id="file_input" type="file" name="fileInput" id="fileInput" accept=".json">
                <p class="mt-1 text-sm text-gray-500" id="file_input_help">Accepted file format(s): JSON</p>
            </div>
            <br>
            <br>
            <br>
            <div class="justify-center flex flex-row">
                <button class="flex py-2 px-3 bg-accredify-700 hover:bg-accredify-500 rounded-full">
                    <span class="text-white inline mr-1">Verify</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="white" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75" />
                    </svg>
                </button>
            </div>
            @if($errors->any())
            <div class="text-red-500 text-xs mt-3">Verification failed with error(s):</div>
            @foreach ($errors->all() as $error)
            <li class="text-red-700 text-xs">{{$error}}</li>
            @endforeach
            @endif

            @if(session()->has('message'))
            <div class="text-green-500 text-xs mt-3 flex flex-grow justify-center">{{session()->get('message')}}</div>
            @endif
        </form>

        <form action="/logout" method="POST">
            @csrf
            <button class="bg-red-600 hover:bg-red-500 py-1 px-3 rounded-full text-white text-sm mt-2">Logout</button>
        </form>
        @include('footer')
    </div>
    @else
    @endauth
</body>

</html>