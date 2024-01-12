<script setup>
import Table from "@/Components/Table.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router, useForm } from "@inertiajs/vue3";
import CustomModal from "@/Components/CustomModal.vue";
import { ref } from "vue";
import { createToaster } from "@meforma/vue-toaster";
import UrlRow from "@/Components/UrlRow.vue";

const props = defineProps({
    urls: Object,
});
console.log(props.urls, "the value of urlsl");

const toaster = createToaster({ position: "top-right", duration: 4000 });

const showCreateModal = ref(false);
const form = useForm({ long_url: "", errors: "" });

const handleCreate = () => {
    router.post(route("urls:store"), form.data(), {
        onSuccess: () => {
            showCreateModal.value = false;
            form.reset();
            toaster.success("Successfully added your link..!");
        },
        onError: (error) => {
            form.errors = error;
        },
    });
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Urls
                </h2>
                <button class="btn-primary" @click="showCreateModal = true">
                    Add url
                </button>
            </div>
        </template>

        <div class="py-12 bg-gray-100">
            <Table
                v-if="urls?.data"
                :pagination="{
                    enable: urls?.total > 10 ? true : false,
                    links: urls?.links,
                    preserveState: true,
                }"
               
            >
                <template #thead>
                    <th
                        class="p-1 w-1/6 sm:p-4 text-center bg-gray-100 text-sm font-medium text-gray-700"
                    >
                        Short Url
                    </th>

                    <th
                        class="p-1 w-1/6 sm:p-4 text-center bg-gray-100 text-sm font-medium text-gray-700"
                    >
                        Long Url
                    </th>
                    <td
                        class="p-1 w-1/6 sm:p-4 text-center bg-gray-100 text-sm font-medium text-gray-700"
                    >
                        Total Clicks
                    </td>
                    <td
                        class="p-1 w-1/6 sm:p-4 text-center bg-gray-100 text-sm font-medium text-gray-700"
                    >
                        Action
                    </td>
                </template>

                <template #tbody>
                    <!-- <tr
                        v-for="url in urls.data"
                        :key="url.id"
                        class="hover:bg-gray-100 transition-colors group border-t border-gray-200 cursor-pointer"
                    > -->
                        <UrlRow :urls="urls" />
                    <!-- </tr> -->
                </template>
            </Table>
            <div
                v-else
                class="my-16 flex w-full justify-center items-center text-gray-600 text-3xl"
            >
                No url found
            </div>
        </div>
    </AuthenticatedLayout>
    <CustomModal title="Create new url" :open="showCreateModal">
        <template #body>
            <div>
                <input
                    type="text"
                    name="url"
                    class="border my-4 border-gray-400 rounded-md w-full p-2"
                    v-model="form.long_url"
                    placeholder="Type your longest url..."
                />
            </div>
            <div class="text-xs text-red-500">
                <p
                    v-if="form.errors?.long_url"
                    class="text-center mb-4"
                    v-text="form.errors?.long_url"
                ></p>
            </div>
            <div class="flex justify-center gap-5 pt-5">
                <button
                    @click="showCreateModal = false"
                    class="btn-primary bg-red-500"
                >
                    Close
                </button>
                <button @click="handleCreate" class="btn-primary mr-2">
                    Create
                </button>
            </div>
        </template>
    </CustomModal>
</template>
