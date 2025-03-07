<script setup lang="ts">
import type IProduct from '@/Pages/Products/types'
import type ICategory from '@/types/Category'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

import { router, useForm } from '@inertiajs/vue3'
import { useTimeoutFn } from '@vueuse/core'
import { ElMessage } from 'element-plus'
import { ref } from 'vue'

const props = defineProps<{
  product?: IProduct
  categories: ICategory[]
}>()

const hasError = ref(true)
const form = useForm({
  name: props.product?.name ?? '',
  description: props.product?.description ?? '',
  category_id: props.product?.category.id ?? '',
  price: Number.parseFloat(props.product?.price ?? '0.00'),
})

function onSubmit() {
  if (props.product) {
    form.put(route('products.update', { id: props.product.id }), {
      onSuccess: () => ElMessage({
        message: 'Сохранено',
        type: 'success',
      }),
      onError: () => useTimeoutFn(() => hasError.value = false, 3000),
    })
  } else {
    form.post(route('products.store'), {
      onSuccess: () => ElMessage({
        message: 'Сохранено',
        type: 'success',
      }),
      onError: () => useTimeoutFn(() => hasError.value = false, 3000),
    })
  }
}
</script>

<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        Продукты
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div
          class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
        >
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="rounded-md">
              <el-card class="max-w-xl">
                <el-form
                  label-position="left"
                  label-width="100"
                  :model="form"
                >
                  <el-form-item
                    label="Имя"
                    label-position="left"
                    :validate-status="form.errors.name && hasError ? 'error' : 'success'"
                  >
                    <el-input v-model="form.name" />
                    <div v-if="form.errors.name && hasError" class="text-xs text-red-600">
                      {{ form.errors.name }}
                    </div>
                  </el-form-item>
                  <el-form-item
                    label="Описание"
                    label-position="left"
                    :validate-status="form.errors.description && hasError ? 'error' : 'success'"
                  >
                    <el-input
                      v-model="form.description"
                      :autosize="{ minRows: 6 }"
                      type="textarea"
                    />
                    <div v-if="form.errors.description && hasError" class="text-xs text-red-600">
                      {{ form.errors.description }}
                    </div>
                  </el-form-item>
                  <el-form-item
                    label="Категория" label-position="left"
                    :validate-status="form.errors.category_id && hasError ? 'error' : 'success'"
                  >
                    <el-select v-model="form.category_id" placeholder="">
                      <el-option
                        v-for="item in props.categories"
                        :key="item.id"
                        :label="item.name"
                        :value="item.id"
                      />
                    </el-select>
                    <div v-if="form.errors.category_id && hasError" class="text-xs text-red-600">
                      {{ form.errors.category_id }}
                    </div>
                  </el-form-item>
                  <el-form-item
                    label="Цена"
                    label-position="left"
                    :validate-status="form.errors.price && hasError ? 'error' : 'success'"
                  >
                    <el-input-number v-model="form.price" :precision="2" :step="0.01" :min="0.01" />
                    <div v-if="form.errors.price && hasError" class="text-xs text-red-600">
                      {{ form.errors.price }}
                    </div>
                  </el-form-item>
                  <el-form-item>
                    <el-button type="primary" plain @click="onSubmit">
                      Сохранить
                    </el-button>
                    <el-button type="warning" @click="router.visit(route('products.index'))">
                      Назад
                    </el-button>
                  </el-form-item>
                </el-form>
              </el-card>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>

</style>
