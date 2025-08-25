<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 dark:bg-gray-900">
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
  <div class="bg-white shadow-lg rounded-2xl p-10 w-[543px]">
    <!-- Logo -->
    <div class="flex justify-center mb-6">
      <x-application-logo class="h-24 w-24" />
    </div>

    <!-- Welcome Text -->
    <div class="text-center mb-6">
      <h1 class="text-xl font-medium text-gray-800">Hello, Welcome Back to FLOWS</h1>
      <p class="text-sm text-gray-600">You Ready? Let’s Go!</p>
    </div>

    <!-- Email -->
    <div class="mb-4">
      <label class="block text-sm text-gray-800 mb-2">Email</label>
      <input type="email" placeholder="Enter Email"
             class="w-full px-4 py-3 border rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500">
    </div>

    <!-- Password -->
    <div class="mb-4">
      <label class="block text-sm text-gray-800 mb-2">Password</label>
      <input type="password" placeholder="Enter Password"
             class="w-full px-4 py-3 border rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500">
    </div>

    <!-- Options -->
    <div class="flex items-center justify-between mb-6">
      <label class="flex items-center space-x-2 text-sm text-gray-700">
        <input type="checkbox" class="w-4 h-4 text-red-600 rounded">
        <span>Remember Me</span>
      </label>
      <a href="#" class="text-sm text-red-600 hover:underline">Forgot Password?</a>
    </div>

    <!-- Login Button -->
    <button class="w-full bg-red-600 text-white py-3 rounded-full shadow hover:bg-red-700">
      LOGIN
    </button>

    <!-- Footer -->
    <p class="text-center text-sm text-gray-700 mt-6">
      Don’t Have An Account Yet?
      <a href="#" class="text-red-600 hover:underline">Sign Up</a>
    </p>
  </div>
</div>

    </div>
</x-guest-layout>
