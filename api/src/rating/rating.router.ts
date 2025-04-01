import { Router } from 'express'
import { getRating, getRatingById, createRating, updateRating, deleteRating } from './rating.controller'

export const ratingRouter = Router()

ratingRouter.get('/ratings', getRating)
ratingRouter.get('/ratings/:id_rating', getRatingById)
ratingRouter.post('/ratings', createRating)
ratingRouter.patch('/ratings/:id_rating', updateRating)
ratingRouter.delete('/ratings/:id_rating', deleteRating)
