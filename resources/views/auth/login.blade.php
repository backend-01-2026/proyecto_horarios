<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Iniciar Sesión · Sistema de Horarios</title>
@vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-red-900 via-red-700 to-red-500 flex items-center justify-center p-4">

<div class="w-full max-w-6xl bg-white rounded-3xl overflow-hidden shadow-2xl grid lg:grid-cols-2">

<div class="hidden lg:flex flex-col justify-center items-center bg-gradient-to-b from-red-900 to-red-700 text-white p-10">
    <img src="{{ asset('img/logo2.png') }}" alt="Logo UATF" class="w-80 mb-6">
      <div class="w-32 h-1 bg-white my-6 rounded"></div>
    <h1 class="text-4xl font-bold text-center">UNIVERSIDAD<br>AUTÓNOMA<br>TOMÁS FRÍAS</h1>
  
   
    
</div>

<div class="p-8 md:p-14">
<div class="lg:hidden text-center mb-8">
<img src="{{ asset('img/logo2.png') }}" class="w-40 mx-auto mb-4">
<h1 class="text-4xl font-bold text-center"><span class="text-red-700">UNIVERSIDAD</span><br>AUTÓNOMA<br>TOMÁS FRÍAS</h1>
<h6 class="text-gray-500"><br><span class="font-bold text-black-700">Ingeniería</span> <span class="font-bold text-red-700">Informática</span></h6>
</div>

<h2 class="hidden lg:block text-4xl font-bold text-gray-800">Ingeniería <span class="text-red-700">Informática</span></h2>


@if($errors->any())
<div class="mb-6 rounded-lg border-l-4 border-red-600 bg-red-50 p-4">
<ul class="text-red-700 text-sm">
@foreach($errors->all() as $error)
<li>• {{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<form method="POST" action="{{ route('login') }}" class="space-y-6">
@csrf

<div>
<label class="block mb-2 font-semibold text-gray-700"><br>Correo electrónico</label>
<input type="email" name="email" value="{{ old('email') }}" required autofocus
class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-red-600 focus:ring-2 focus:ring-red-300 outline-none">
</div>

<div>
<label class="block mb-2 font-semibold text-gray-700">Contraseña</label>
<input type="password" name="password" required
class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-red-600 focus:ring-2 focus:ring-red-300 outline-none">
</div>

<button type="submit"
class="w-full rounded-xl bg-red-700 hover:bg-red-800 transition text-white font-bold py-3 shadow-lg hover:scale-[1.02]">
Iniciar Sesión
</button>

<div class="text-center">
<a href="{{ route('register') }}" class="text-red-700 hover:underline font-semibold">
¿No tienes cuenta? Regístrate
</a>
</div>
</form>

<p class="mt-10 text-center text-xs text-gray-400">
© {{ date('Y') }} Universidad Autónoma Tomás Frías
</p>

</div>
</div>

</body>
</html>
