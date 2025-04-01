import { Router } from 'express'
import { createUser, fetchUser, login } from './user.controller'

export const userRouter = Router()

userRouter.get('/users/:userId', fetchUser)
userRouter.post('/users', createUser)
userRouter.post('/users/login', login)
