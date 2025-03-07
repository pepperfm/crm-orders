import type IProduct from '@/Pages/Products/types'
import type { User } from '@/types'

export default interface IOrder {
  id: number
  user: User
  product: IProduct
  sum: string
  status: number
  status_label: string
  created_at: string
}
