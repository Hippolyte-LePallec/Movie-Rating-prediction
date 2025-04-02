import { Router } from 'express'
import { getMediaGenres, createMediaGenre, deleteMediaGenre } from './mediaGenre.controller'

export const mediaGenreRouter = Router()

mediaGenreRouter.get('/mediaGenres', getMediaGenres)
mediaGenreRouter.post('/mediaGenres', createMediaGenre)
mediaGenreRouter.delete('/mediaGenres/:mediaId/:genreId', deleteMediaGenre)
