<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import {Head, router, useForm} from '@inertiajs/vue3';
    import Table from '@/Components/Table.vue';
    import Pagination from '@/Components/Pagination.vue';
    import Delete from '@/Components/DangerButton.vue';
    import Update from '@/Components/UpdateButton.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    import Modal from '@/Components/Modal.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import {ref, defineProps} from 'vue';

    const showModal = ref(false);

    const form = useForm({
        full_name: '',
        phone: '',
        citi: '',
        feedback: '',
    });

    const props = defineProps({
        feedback: {
            type: Object,
            default: {}
        },
    });

    function destroy(id) {
        if (confirm('Ви впевнені що хочете видалити відгук')) {
            router.delete(route('feedback-list.destroy', id));
        }
    }

    function setForm(feedback) {
        showModal.value = true;

        form.full_name = feedback.fullName;
        form.phone = feedback.phone;
        form.city = feedback.city;
        form.feedback = feedback.feedback;
    }

    function update() {
        // send request to update feedback
    }

    function closeModal() {
        showModal.value = false;
    }
</script>

<template>
    <Head title="Feed back lists" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Feed back lists</h2>
        </template>

        <div class="py-12">
            <div class="max mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <Table :data="props.feedback.data" :headers="['№', 'П.І.Б', 'Телефон', 'Місто', 'Відгук', 'Створено', 'Оновлено']">
                            <template v-slot:action="data">
                                <Update @click="setForm(data.item)" class="mr-3">Оновити</Update>
                                <Delete @click="destroy(data.item.id)">Видалити</Delete>
                            </template>
                        </Table>
                        <br/>
                        <Pagination
                            :meta="props.feedback.meta"
                            :links="props.feedback.links"
                        />

                        <Modal :show="showModal" @close="closeModal">
                            <div class="p-6">
                                <h2 class="text-lg font-medium text-gray-900 py-4">
                                    Оновити відгук від "<b class="capitalize underline">{{ form.full_name }}</b>"
                                </h2>

                                <hr/>
                                <!-- Full name -->
                                <div class="mt-6">
                                    <InputLabel for="full_name" value="П.І.Б:" class="sr-only" />

                                    <TextInput
                                        id="full_name"
                                        v-model="form.full_name"
                                        type="text"
                                        class="mt-1 block w-3/4"
                                        placeholder="П.І.Б"
                                    />

                                    <InputError :message="form.errors.full_name" class="mt-2" />
                                </div>
                                <!-- Phone -->
                                <div class="mt-4">
                                    <InputLabel for="phone" value="Phone:" class="sr-only" />

                                    <TextInput
                                        id="phone"
                                        v-model="form.phone"
                                        type="text"
                                        class="mt-1 block w-3/4"
                                        placeholder="Phone"
                                    />

                                    <InputError :message="form.errors.phone" class="mt-2" />
                                </div>
                                <!-- City -->
                                <div class="mt-4">
                                    <InputLabel for="city" value="Місто:" class="sr-only" />

                                    <TextInput
                                        id="city"
                                        v-model="form.city"
                                        type="text"
                                        class="mt-1 block w-3/4"
                                        placeholder="Місто"
                                    />

                                    <InputError :message="form.errors.city" class="mt-2" />
                                </div>

                                <!-- Feedback -->
                                <div class="mt-4">
                                    <InputLabel for="feedback" value="Відгук:" class="sr-only" />

                                    <textarea
                                        id="feedback"
                                        v-model="form.feedback"
                                        type="text"
                                        rows="7"
                                        class="mt-1 block w-3/4 rounded-md"
                                        placeholder="Відгук"
                                    >
                                        {{ form.feedback }}
                                    </textarea>

                                    <InputError :message="form.errors.feedback" class="mt-2" />
                                </div>

                                <div class="mt-6 flex justify-end">
                                    <SecondaryButton @click="closeModal"> Закрити </SecondaryButton>

                                    <Update
                                        class="ml-3"
                                        :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing"
                                        @click="update"
                                    >
                                        Оновити
                                    </Update>
                                </div>
                            </div>
                        </Modal>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
    span[name=feedback] {
        display: block;
        width: 300px;
        height: 70px;
        overflow-y: auto;
    }
</style>
