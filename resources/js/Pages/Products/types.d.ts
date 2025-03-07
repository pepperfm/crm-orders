import type ICategory from '@/types/Category'

export default interface IProduct {
  id: number
  name: string
  description: string
  price: string
  category: ICategory
}
