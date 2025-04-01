import { Router } from 'express'
import { getCrew, getCrewById, createCrew, updateCrew, deleteCrew } from './crew.controller'

export const crewRouter = Router()

crewRouter.get('/crews', getCrew)
crewRouter.get('/crews/:id_crew', getCrewById)
crewRouter.post('/crews', createCrew)
crewRouter.patch('/crews/:id_crew', updateCrew)
crewRouter.delete('/crews/:id_crew', deleteCrew)