import { Router } from 'express'
import { getCategories, getCategoryById, createCategory, updateCategory, deleteCategory } from './categorie.controller'

export const categorieRouter = Router()

categorieRouter.get('/categories', getCategories)
categorieRouter.get('/categories/:id_categorie', getCategoryById)
categorieRouter.post('/categories', createCategory)
categorieRouter.patch('/categories/:id_categorie', updateCategory)
categorieRouter.delete('/categories/:id_categorie', deleteCategory)
