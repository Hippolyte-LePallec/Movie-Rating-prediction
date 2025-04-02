import { Router } from 'express'
import { getEpisode, getEpisodeById, createEpisode, updateEpisode, deleteEpisode } from './episode.controller'

export const episodeRouter = Router()

episodeRouter.get('/episodes', getEpisode)
episodeRouter.get('/episodes/:id_episode', getEpisodeById)
episodeRouter.post('/episodes', createEpisode)
episodeRouter.patch('/episodes/:id_episode', updateEpisode)
episodeRouter.delete('/episodes/:id_episode', deleteEpisode)
