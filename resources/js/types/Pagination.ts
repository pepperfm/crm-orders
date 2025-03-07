export interface ICursorPaginatedResponse<T> {
  data: T[]
  next_cursor: string
  next_page_url: string | null | URL
  path: string
  per_page: number
  prev_cursor: string
  prev_page_url: string | null | URL
}

export interface IPaginatedResponse<T> {
  current_page: number
  data: T[]
  first_page_url: string
  per_page: number
  last_page: number
  last_page_url: string
  links: IPaginationLink[]
  from: number
  to: number
  total: number
  prev_page_url: string | URL
  next_page_url: string | URL
  path: string
}

export interface IPaginationLink {
  url: string | null | URL
  label: string
  active: boolean
}

export type PartialCursorPaginatedResponse<T> = Partial<ICursorPaginatedResponse<T>>
