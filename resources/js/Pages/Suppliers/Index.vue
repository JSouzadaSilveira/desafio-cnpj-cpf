<template>
    <Head title="Fornecedores" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Fornecedores
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-6">
                            <h1 class="text-2xl font-semibold">Lista de Fornecedores</h1>
                            <PrimaryButton @click="openModal">
                                Novo Fornecedor
                            </PrimaryButton>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nome
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Documento
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Email
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Telefone
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Ações
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="supplier in suppliers.data" :key="supplier.id">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ supplier.name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ supplier.document }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ supplier.email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ supplier.phone }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <Link
                                                :href="route('suppliers.edit', supplier.id)"
                                                class="text-indigo-600 hover:text-indigo-900 mr-3"
                                            >
                                                Editar
                                            </Link>
                                            <Link
                                                :href="route('suppliers.show', supplier.id)"
                                                class="text-blue-600 hover:text-blue-900"
                                            >
                                                Ver
                                            </Link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginação -->
                        <div class="mt-4" v-if="suppliers.links && suppliers.links.length > 3">
                            <div class="flex justify-between items-center">
                                <div class="flex-1 flex justify-between sm:hidden">
                                    <Link
                                        v-if="suppliers.prev_page_url"
                                        :href="suppliers.prev_page_url"
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                                    >
                                        Anterior
                                    </Link>
                                    <Link
                                        v-if="suppliers.next_page_url"
                                        :href="suppliers.next_page_url"
                                        class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                                    >
                                        Próximo
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Criação de Fornecedor -->
        <Modal :show="showingModal" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Novo Fornecedor
                </h2>

                <form @submit.prevent="submit" class="mt-6">
                    <div class="mb-4">
                        <InputLabel for="name" value="Nome" />
                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.name"
                            required
                            autofocus
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="mb-4">
                        <InputLabel for="document" value="CNPJ/CPF" />
                        <TextInput
                            id="document"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.document"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.document" />
                    </div>

                    <div class="mb-4">
                        <InputLabel for="email" value="E-mail" />
                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mb-4">
                        <InputLabel for="phone" value="Telefone" />
                        <TextInput
                            id="phone"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.phone"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.phone" />
                    </div>

                    <div class="mb-4">
                        <InputLabel for="address" value="Endereço" />
                        <TextInput
                            id="address"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.address"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.address" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <InputLabel for="city" value="Cidade" />
                            <TextInput
                                id="city"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.city"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.city" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="state" value="Estado" />
                            <TextInput
                                id="state"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.state"
                                maxlength="2"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.state" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <InputLabel for="zip_code" value="CEP" />
                            <TextInput
                                id="zip_code"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.zip_code"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.zip_code" />
                        </div>

                        <div class="mb-4">
                            <InputLabel for="contact_name" value="Nome do Contato" />
                            <TextInput
                                id="contact_name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.contact_name"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.contact_name" />
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="closeModal" class="mr-3">
                            Cancelar
                        </SecondaryButton>
                        <PrimaryButton :disabled="form.processing">
                            Salvar
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { route } from 'ziggy-js';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

defineProps({
    suppliers: {
        type: Object,
        required: true
    }
});

const showingModal = ref(false);

const form = useForm({
    name: '',
    document: '',
    email: '',
    phone: '',
    address: '',
    city: '',
    state: '',
    zip_code: '',
    contact_name: ''
});

const submit = () => {
    form.post(route('suppliers.store'), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
        },
    });
};

const openModal = () => {
    form.reset();
    showingModal.value = true;
};

const closeModal = () => {
    showingModal.value = false;
    form.reset();
};
</script>
