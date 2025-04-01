import { Router } from 'express'
import { getMedia, getMediaById, createMedia, updateMedia, deleteMedia } from './media.controller'

export const mediaRouter = Router()

mediaRouter.get('/medias', getMedia)
mediaRouter.get('/medias/:id_media', getMediaById)
mediaRouter.post('/medias', createMedia)
mediaRouter.patch('/medias/:id_media', updateMedia)
mediaRouter.delete('/medias/:id_media', deleteMedia)
