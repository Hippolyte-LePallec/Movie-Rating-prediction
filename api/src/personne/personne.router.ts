import { Router } from 'express'
import { getPersonne, getPersonneById, createPersonne, updatePersonne, deletePersonne } from './personne.controller'

export const personneRouter = Router()

personneRouter.get('/personnes', getPersonne)
personneRouter.get('/personnes/:id_name', getPersonneById)
personneRouter.post('/personnes', createPersonne)
personneRouter.patch('/personnes/:id_name', updatePersonne)
personneRouter.delete('/personnes/:id_name', deletePersonne)
