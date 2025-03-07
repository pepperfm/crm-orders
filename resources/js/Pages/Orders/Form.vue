<script setup lang="ts">
import type IOrder from '@/Pages/Orders/types'

import type IProduct from '@/Pages/Products/types'
import type { User } from '@/types'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { router, useForm } from '@inertiajs/vue3'
import { useTimeoutFn } from '@vueuse/core'
import { ElMessage } from 'element-plus'
import { ref } from 'vue'

const props = defineProps<{
  order?: IOrder
  users: User[]
  products: IProduct[]
  statuses: { key: number, label: string }[]
}>()

const hasError = ref(true)
const form = useForm({
  user_id: props.order?.user.id,
  product_id: props.order?.product.id,
  status: props.order?.status,
  created_at: props.order?.created_at,
})

function onSubmit() {
  if (props.order) {
    form.put(route('orders.update', { id: props.order.id }), {
      onSuccess: () => ElMessage({
        message: 'Сохранено',
        type: 'success',
      }),
      onError: () => useTimeoutFn(() => hasError.value = false, 3000),
    })
  }
  else {
    form.post(route('orders.store'), {
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
                  label-width="150"
                  :model="form"
                >
                  <el-form-item
                    label="Покупатель"
                    label-position="left"
                    :validate-status="form.errors.user_id && hasError ? 'error' : 'success'"
                  >
                    <el-select v-model="form.user_id" placeholder="" filterable>
                      <el-option
                        v-for="item in props.users"
                        :key="item.id"
                        :label="item.name"
                        :value="item.id"
                      />
                    </el-select>
                    <div v-if="form.errors.user_id && hasError" class="text-xs text-red-600">
                      {{ form.errors.user_id }}
                    </div>
                  </el-form-item>
                  <el-form-item
                    label="Продукт"
                    label-position="left"
                    :validate-status="form.errors.product_id && hasError ? 'error' : 'success'"
                  >
                    <el-select v-model="form.product_id" placeholder="" filterable>
                      <el-option
                        v-for="item in props.products"
                        :key="item.id"
                        :label="item.name"
                        :value="item.id"
                      />
                    </el-select>
                    <div v-if="form.errors.product_id && hasError" class="text-xs text-red-600">
                      {{ form.errors.product_id }}
                    </div>
                  </el-form-item>
                  <el-form-item
                    v-if="props.order"
                    label="Статус"
                    label-position="left"
                    :validate-status="form.errors.status && hasError ? 'error' : 'success'"
                  >
                    <el-select v-model="form.status" placeholder="" filterable>
                      <el-option
                        v-for="item in props.statuses"
                        :key="item.key"
                        :label="item.label"
                        :value="item.key"
                      />
                    </el-select>
                    <div v-if="form.errors.status && hasError" class="text-xs text-red-600">
                      {{ form.errors.status }}
                    </div>
                  </el-form-item>
                  <el-form-item
                    v-if="props.order"
                    label="Дата создания"
                    disabled
                    readonly
                    input-style="width: 100%"
                  >
                    <el-input v-model="form.created_at" input-style="color: grey" />
                  </el-form-item>
                  <el-form-item>
                    <el-button type="primary" plain @click="onSubmit">
                      Сохранить
                    </el-button>
                    <el-button type="warning" @click="router.visit(route('orders.index'))">
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
