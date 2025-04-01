import { Router } from 'express'
import { getGenre, getGenreById, createGenre, updateGenre, deleteGenre } from './genre.controller'

export const genreRouter = Router()

genreRouter.get('/genres', getGenre)
genreRouter.get('/genres/:id_genre', getGenreById)
genreRouter.post('/genres', createGenre)
genreRouter.patch('/genres/:id_genre', updateGenre)
genreRouter.delete('/genres/:id_genre', deleteGenre)

