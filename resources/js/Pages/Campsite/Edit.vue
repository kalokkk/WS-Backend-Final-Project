
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router, useForm } from "@inertiajs/vue3";

const props = defineProps({ form: Object });

const form = useForm({
  ...props.form,
  ...{ file: null },
});

const save = () => {
  if (form.id) {
    form
      .transform((data) => ({
        ...data,
        _method: "put",
      }))
      .post(route("campsites.store", { campsite: form.id }));
  } else {
    form.post(route("campsites.create"));
  }
};
</script>


<template>
  <Head title="Campsites" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Campsites
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div
          class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark"
        >
          <div class="flex flex-col gap-5.5 p-6.5">
            <div>
              <label
                class="mb-3 block text-sm font-medium text-black dark:text-white"
              >
                Name
              </label>
              <input
                name="name"
                type="text"
                placeholder="Name of the camp site"
                v-model="form.name"
                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
              />
              <p class="my-3 text-red-600" v-if="form.errors.name">
                {{ form.errors.name }}
              </p>
            </div>
            <div>
              <label
                class="mb-3 block text-sm font-medium text-black dark:text-white"
              >
                Description
              </label>
              <textarea
                name="description"
                rows="3"
                placeholder="General description of camp site"
                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
                v-model="form.description"
              ></textarea>
              <p class="my-3 text-red-600" v-if="form.errors.description">
                {{ form.errors.description }}
              </p>
            </div>
            <div>
              <label
                class="mb-3 block text-sm font-medium text-black dark:text-white"
              >
                Location
              </label>
              <input
                name="location"
                type="text"
                placeholder="Location description"
                v-model="form.location"
                class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary"
              />
              <p class="my-3 text-red-600" v-if="form.errors.location">
                {{ form.errors.location }}
              </p>
            </div>

            <div>
              <label
                class="mb-3 block text-sm font-medium text-black dark:text-white"
              >
                Images
              </label>

              <div class="grid grid-cols-4 pb-4">
                <img
                  v-for="image in form.campsite_images"
                  :key="image.id"
                  :src="
                    route('campsites.image', {
                      campsite: form.id,
                      campsite_image: image.id,
                    })
                  "
                  class="w-30"
                />
              </div>
              <input type="file" @input="form.file = $event.target.files[0]" />
            </div>
            <div>
              <button
                @click="save"
                class="flex justify-center rounded bg-indigo-600 text-white p-3 font-medium text-gray hover:bg-opacity-90 px-10"
              >
                Save
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style>
</style>