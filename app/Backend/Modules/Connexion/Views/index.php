<div class="flex flex-col items-center justify-center md:h-screen">
    <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
        Ecommerce
    </a>
    <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                Espace Administrateur
            </h1>
            <form class="space-y-4 md:space-y-6" action="" method="post">
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Adresse
                        Mail</label>
                    <input type="email" name="email"
                           class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           required>
                </div>
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mot de
                        passe</label>
                    <input type="password" name="password"
                           class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           required>
                </div>
                <div class="flex items-center justify-between">
                    <a href="/forgot-password.html"
                       class="text-sm font-medium text-primary-600 hover:text-blue-600 hover:underline dark:text-primary-500">Mot
                        de passe oublié?</a>
                </div>
                <button type="submit" name="login"
                        class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                    Se connecter
                </button>
                <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                    Tu n'as pas encore de compte? <a href="/admin/register.html"
                                                     class="font-medium text-primary-600 hover:underline dark:text-primary-500 hover:text-blue-600">Inscris-toi</a>
                </p>
            </form>
        </div>
    </div>
</div>