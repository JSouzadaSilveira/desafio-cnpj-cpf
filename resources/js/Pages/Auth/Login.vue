<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <Head title="Log in" />

            <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit">
                <div>
                    <label class="block font-medium text-sm text-gray-700" for="email">
                        Email
                    </label>
                    <input v-model="form.email"
                           id="email"
                           type="email"
                           class="block mt-1 w-full rounded-md border-gray-300"
                           required
                           autofocus
                           autocomplete="username">
                </div>

                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700" for="password">
                        Senha
                    </label>
                    <input v-model="form.password"
                           id="password"
                           type="password"
                           class="block mt-1 w-full rounded-md border-gray-300"
                           required
                           autocomplete="current-password">
                </div>

                <div class="block mt-4">
                    <label class="flex items-center">
                        <input v-model="form.remember" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm">
                        <span class="ml-2 text-sm text-gray-600">Lembrar-me</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing">
                        Entrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
