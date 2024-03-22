<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800,900&display=swap" rel="stylesheet" />


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans bg-gray-200 text-ivory antialiased">
    @include('components.owner.navbar')
    <div class="min-h-screen bg-eerieBlack">

        <!-- Page Content -->
        <main class="flex flex-col items-center pt-6">
            <div class="mt-3 mb-12 px-6 bg-black shadow-md overflow-hidden sm:rounded-lg">
                <div class="px-6 py-3 text-left text-green-700">
                    @if (session()->has('success'))
                        <div>
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
                <div>
                    <table>
                        <thead>
                            <tr>
                                <th class="px-6 py-2.5 text-left">ID</th>
                                <th class="px-6 py-2.5 text-left">Code</th>
                                <th class="px-6 py-2.5 text-left">Name</th>
                                <th class="px-6 py-2.5 text-left">Quantity</th>
                                <th class="px-6 py-2.5 text-left">Price</th>
                                <th class="px-6 py-2.5 text-left">Description</th>
                            </tr>
                        </thead>
            
                        <tbody>
                            @foreach ($products as $product)
                                <tr class="border-t">
                                    <td class="px-6 py-2.5">{{ $product->id }}</td>
                                    <td class="px-6 py-2.5">{{ $product->code }}</td>
                                    <td class="px-6 py-2.5">{{ $product->name }}</td>
                                    <td class="px-6 py-2.5">{{ $product->quantity }}</td>
                                    <td class="px-6 py-2.5">{{ $product->price }}</td>
                                    <td class="px-6 py-2.5">{{ $product->description }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="my-2">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
