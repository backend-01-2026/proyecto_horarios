<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registrarse · Sistema de Horarios</title>
    @vite(["resources/css/app.css", "resources/js/app.js"])
  </head>
  <body class="flex min-h-screen p-4 bg-gradient-to-br from-red-900 via-red-700 to-red-500 items-center justify-center">
    <div class="overflow-hidden grid w-full max-w-6xl bg-white rounded-3xl shadow-2xl lg:grid-cols-2">
      <div class="hidden flex-col p-10 text-white bg-gradient-to-b from-red-900 to-red-700 justify-center items-center lg:flex">
        <img
          src="{{ asset("img/logo2.png") }}"
          alt="Logo UATF"
          class="w-80 mb-6"/>
        <div class="w-32 h-1 my-6 bg-white rounded"></div>
        <h1 class="text-4xl font-bold text-center">
          UNIVERSIDAD
          <br />
          AUTÓNOMA
          <br />
          TOMÁS FRÍAS
        </h1>
      </div>
      <div class="p-8 md:p-14 bg-gradient-to-br from-white via-white to-red-50">
        <div class="mb-8 text-center lg:hidden">
          <img src="{{ asset("img/logo2.png") }}" class="w-40 mx-auto mb-4"/>
          <h1 class="text-4xl font-bold text-center">
            <span class="text-red-700">UNIVERSIDAD</span>
            <br />
            AUTÓNOMA
            <br />
            TOMÁS FRÍAS
          </h1>
          <h6 class="text-gray-500">
            <br />
            <span class="font-bold text-black-700">Ingeniería</span>
            <span class="font-bold text-red-700">Informática</span>
          </h6>
        </div>
        <h2 class="hidden text-4xl font-bold text-center text-gray-800 lg:block">
          Registrarse
        </h2>
        @if ($errors->any())
          <div class="mb-6 p-4 bg-red-50 rounded-lg border-l-4 border-red-600">
            <ul class="text-red-700 text-sm">
              @foreach ($errors->all() as $error)
                <li>• {{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        <form method="POST" action="{{ route("register") }}" class="space-y-8">
          @csrf
          <div class="relative">
            <input
              type="text"
              name="name"
              id="name"
              value="{{ old("name") }}"
              required
              autofocus
              placeholder=" "
              class="peer w-full px-0 py-3 border-0 border-b-2 border-gray-300 focus:border-red-600 focus:ring-0 outline-none bg-transparent transition-colors @error("name") border-red-500 @enderror"/>
            <label
              for="name"
              class="absolute left-0 text-gray-400 transition-all duration-200 pointer-events-none
                peer-placeholder-shown:text-base peer-placeholder-shown:top-3
                peer-focus:text-sm peer-focus:-top-3.5 peer-focus:text-red-600
                peer-not-placeholder-shown:text-sm peer-not-placeholder-shown:-top-3.5 peer-not-placeholder-shown:text-gray-600">
              Nombres
            </label>
            @error("name")
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
          <div class="relative">
            <input
              type="text"
              name="lastname"
              id="lastname"
              value="{{ old("lastname") }}"
              required
              placeholder=" "
              class="peer w-full px-0 py-3 border-0 border-b-2 border-gray-300 focus:border-red-600 focus:ring-0 outline-none bg-transparent transition-colors @error("lastname") border-red-500 @enderror"/>
            <label
              for="lastname"
              class="absolute left-0 text-gray-400 transition-all duration-200 pointer-events-none
                peer-placeholder-shown:text-base peer-placeholder-shown:top-3
                peer-focus:text-sm peer-focus:-top-3.5 peer-focus:text-red-600
                peer-not-placeholder-shown:text-sm peer-not-placeholder-shown:-top-3.5 peer-not-placeholder-shown:text-gray-600">
              Apellidos
            </label>
            @error("lastname")
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
          <div class="relative">
            <input
              type="email"
              name="email"
              id="email"
              value="{{ old("email") }}"
              required
              placeholder=" "
              class="peer w-full px-0 py-3 border-0 border-b-2 border-gray-300 focus:border-red-600 focus:ring-0 outline-none bg-transparent transition-colors @error("email") border-red-500 @enderror"/>
            <label
              for="email"
              class="absolute left-0 text-gray-400 transition-all duration-200 pointer-events-none
                peer-placeholder-shown:text-base peer-placeholder-shown:top-3
                peer-focus:text-sm peer-focus:-top-3.5 peer-focus:text-red-600
                peer-not-placeholder-shown:text-sm peer-not-placeholder-shown:-top-3.5 peer-not-placeholder-shown:text-gray-600">
              Correo electrónico
            </label>
            @error("email")
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
          <div class="relative">
            <input
              type="password"
              name="password"
              id="password"
              required
              placeholder=" "
              class="peer w-full px-0 py-3 border-0 border-b-2 border-gray-300 focus:border-red-600 focus:ring-0 outline-none bg-transparent transition-colors @error("password") border-red-500 @enderror"/>
            <label
              for="password"
              class="absolute left-0 text-gray-400 transition-all duration-200 pointer-events-none
                peer-placeholder-shown:text-base peer-placeholder-shown:top-3
                peer-focus:text-sm peer-focus:-top-3.5 peer-focus:text-red-600
                peer-not-placeholder-shown:text-sm peer-not-placeholder-shown:-top-3.5 peer-not-placeholder-shown:text-gray-600">
              Contraseña
            </label>
            @error("password")
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
          <div class="relative">
            <input
              type="password"
              name="password_confirmation"
              id="password_confirmation"
              required
              placeholder=" "
              class="peer w-full px-0 py-3 border-0 border-b-2 border-gray-300 focus:border-red-600 focus:ring-0 outline-none bg-transparent transition-colors"/>
            <label
              for="password_confirmation"
              class="absolute left-0 text-gray-400 transition-all duration-200 pointer-events-none
                peer-placeholder-shown:text-base peer-placeholder-shown:top-3
                peer-focus:text-sm peer-focus:-top-3.5 peer-focus:text-red-600
                peer-not-placeholder-shown:text-sm peer-not-placeholder-shown:-top-3.5 peer-not-placeholder-shown:text-gray-600">
              Confirmar contraseña
            </label>
          </div>
          <button
            type="submit"
            class="w-full py-3 text-white font-bold bg-red-700 rounded-xl shadow-lg hover:bg-red-800 transition hover:scale-[1.02]">
            Crear Cuenta
          </button>
          <div class="text-center">
            <a
              href="{{ route("login") }}"
              class="text-red-700 font-semibold hover:underline">
              ¿Ya tienes cuenta? Inicia sesión
            </a>
          </div>
        </form>
        <p class="mt-10 text-center text-xs text-gray-400">
          © {{ date("Y") }} Universidad Autónoma Tomás Frías
        </p>
      </div>
    </div>
  </body>
</html>
