<script setup lang="ts">
import type IProduct from '@/Pages/Products/types'
import type { IPaginatedResponse } from '@/types/Pagination'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import {
  Delete,
  Edit,
} from '@element-plus/icons-vue'
import { router } from '@inertiajs/vue3'

import { ElMessage } from 'element-plus'
import { computed } from 'vue'

const props = defineProps<{
  data: IPaginatedResponse<IProduct>
}>()

const pagination = computed(() => props.data)

function handlePagination(item: number) {
  router.get(
    route('products.index', {
      page: item,
    }),
  )
}
function handlePrev() {
  router.get(pagination.value.prev_page_url)
}
function handleNext() {
  router.get(pagination.value.next_page_url)
}

function handleCreate() {
  router.visit(route('products.create'))
}
function handleEdit(index: number, row: IProduct) {
  router.get(
    route('products.edit', { id: row.id }),
  )
}
function handleDelete(index: number, row: IProduct) {
  router.delete(route('products.destroy', { id: row.id }), {
    onSuccess: () => {
      ElMessage({
        message: 'Deleted',
        type: 'success',
      })
    },
  })
}
</script>

<template>
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
          Продукты
        </h2>
        <el-button
          type="primary"
          plain
          @click="handleCreate"
        >
          Добавить продукт
        </el-button>
      </div>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <el-table :data="props.data.data" fit :highlight-current-row="true" border table-layout="fixed">
              <el-table-column prop="name" label="Имя" />
              <el-table-column prop="price" label="Цена" class-name="place-items-center" />
              <el-table-column prop="category.name" label="Категория" class-name="place-items-center" />
              <el-table-column fixed="right" label="Operations" min-width="120" class-name="place-items-center">
                <template #default="scope">
                  <el-button type="warning" plain :icon="Edit" circle @click="handleEdit(scope.$index, scope.row)" />
                  <el-button type="danger" :icon="Delete" circle @click="handleDelete(scope.$index, scope.row)" />
                </template>
              </el-table-column>
            </el-table>
            <div class="flex justify-center py-2">
              <el-pagination
                background
                layout="prev, pager, next"
                :total="pagination.total"
                :page-size="pagination.per_page"
                :current-page="pagination.current_page"
                @current-change="handlePagination"
                @prev-click="handlePrev"
                @next-click="handleNext"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>

</style>
