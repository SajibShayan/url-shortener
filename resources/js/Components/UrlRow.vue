<script setup>
import { ref } from "vue";
import CustomModal from "./CustomModal.vue";
import { router, useForm } from "@inertiajs/vue3";
import { createToaster } from "@meforma/vue-toaster";

const props = defineProps({
    urls: Object,
});

const toaster = createToaster({ position: "top-right", duration: 4000 });

const form = useForm({ long_url: '', errors: "" });

const showEditModal = ref(false);
const showDeleteModal = ref(false);
const urlData = ref(null);

const handleEdit = (data) => {
    if (!form.long_url) return;

    console.log(data, 'url data')

    router.put(
        route("urls:update", { url: data?.slug }),
        { long_url: form.long_url },
        {
            onSuccess: () => {
                showEditModal.value = false;
                form.reset();
                toaster.error("Successfully updated the link!");
            },
            onError: (error) => {
                form.errors = error;
            },
        }
    );
};

const handleDelete = (data) => {
    router.delete(route("urls:destroy", { url: data?.slug }), {
        onSuccess: () => {
            showDeleteModal.value = false;
            form.reset();
        },
        onError: () => {
            toaster.error("Something bad happen!");
        },
    });
};
</script>

<template>
    <tr
        v-for="url in urls.data"
        :key="url.id"
        class="hover:bg-gray-100 transition-colors group border-t border-gray-200 cursor-pointer"
    >
        <td class="text-center table-text-style">
            <div class="flex justify-center items-center truncate">
                <a
                    :href="route('urls:redirect', { url: url?.short_code })"
                    target="_blank"
                >
                    {{ route("urls:redirect", { url: url?.short_code }) }}
                </a>
            </div>
        </td>
        <td class="text-center table-text-style">
            <div class="flex justify-start items-center truncate">
                {{ url?.long_url }}
            </div>
        </td>
        <td class="text-center table-text-style">
            <div class="flex justify-center items-center">
                {{ url?.clicks_count }}
            </div>
        </td>

        <td class="text-end table-text-style items-center">
            <div class="flex justify-center items-center gap-4">
                <button class="btn-primary" 
                @click="showEditModal = true, 
                form.long_url = url?.long_url,
                urlData = url
                
                ">
                    Edit
                </button>
                <button class="btn-danger" 
                @click="showDeleteModal = true, 
                form.long_url = url?.long_url,
                urlData = url
                ">
                    Delete
                </button>
            </div>
        </td>
    </tr>

    <CustomModal :open="showDeleteModal" :title="'Do you want to delete this?'">
        <template #body>
            <div class="flex justify-center pt-5 gap-4">
                <button
                    @click="showDeleteModal = false"
                    class="btn-primary bg-red-500"
                >
                    No
                </button>

                <button @click="handleDelete(urlData)" class="btn-success mr-2">
                    Yes
                </button>
            </div>
        </template>
    </CustomModal>

    <CustomModal :open="showEditModal">
        <template #body>
            <div>
                <input
                    type="text"
                    name="tag"
                    id="tag"
                    class="border my-4 border-gray-400 rounded-md w-full p-2"
                    v-model="form.long_url"
                />
            </div>
            <div class="text-xs text-red-500">
                <p
                    v-if="form.errors?.long_url"
                    class="text-center mb-4"
                    v-text="form.errors?.long_url"
                ></p>
            </div>
            <div class="flex justify-center pt-5 gap-4">
                <button
                    @click="showEditModal = false"
                    class="btn-primary bg-red-500"
                >
                    Close
                </button>
                <button
                    @click="handleEdit(urlData)"
                    class="btn-success mr-2"
                    :disabled="!form.long_url"
                >
                    Save
                </button>
            </div>
        </template>
    </CustomModal>
</template>
