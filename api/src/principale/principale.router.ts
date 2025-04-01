import { Router } from 'express'
import { getPrincipals, getPrincipalsByMediaId, getPrincipalsByPersonneId, createPrincipal, updatePrincipal, deletePrincipal } from './principale.controller'

export const principaleRouter = Router()

principaleRouter.get('/principales', getPrincipals)
principaleRouter.get('/principales/:mediaId', getPrincipalsByMediaId)
principaleRouter.get('/principales/:personneId', getPrincipalsByPersonneId)
principaleRouter.post('/principales', createPrincipal)
principaleRouter.patch('/principales/:mediaId/:personneId', updatePrincipal)
principaleRouter.delete('/principales/:mediaId/:personneId', deletePrincipal)
