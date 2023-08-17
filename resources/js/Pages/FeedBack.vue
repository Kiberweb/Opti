<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, router } from '@inertiajs/vue3';
    import Table from '@/Components/Table.vue';
    import Pagination from '@/Components/Pagination.vue';
    import Delete from '@/Components/DangerButton.vue';

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
                        <Table :data="props.feedback.data">
                            <template v-slot:action="data">
                                <Delete @click="destroy(data.item.id)">Delete</Delete>
                                <Delete @click="destroy(data.item.id)">Delete</Delete>
                            </template>
                        </Table>
                        <br/>
                        <Pagination
                            :meta="props.feedback.meta"
                            :links="props.feedback.links"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
