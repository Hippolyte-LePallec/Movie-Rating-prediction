import request from 'supertest'
import { app } from '../src'
import { prismaMock } from './jest.setup'
import bcrypt from 'bcrypt'

describe('User API', () => {
  describe('POST /users', () => {
    it('should create a new user', async () => {
      const newUser = {
        email: 'test@example.com',
        password: 'password123',
      }
      const createdUser = {
        id: 1,
        ...newUser,
      }

      prismaMock.user.create.mockResolvedValue(createdUser)

      const response = await request(app).post('/users').send(newUser)

      expect(response.status).toBe(201)
      expect(response.body).toEqual(createdUser)
    })

    it('should return 500 if user creation fails', async () => {
      prismaMock.user.create.mockRejectedValue(new Error('Database error'))

      const response = await request(app).post('/users').send({
        email: 'test@example.com',
        password: 'password123',
      })

      expect(response.status).toBe(500)
      expect(response.body).toEqual({
        error: 'Failed to create user',
      })
    })
  })

  describe('POST /login', () => {
    it('should login a user and return a token', async () => {
      const user = {
        id: 1,
        email: 'test@example.com',
        password: await bcrypt.hash('password123', 10),
      }
      const token = 'mockedToken'

      prismaMock.user.findUnique.mockResolvedValue(user)

      const response = await request(app).post('/users/login').send({
        email: 'test@example.com',
        password: 'truePassword',
      })

      expect(response.status).toBe(200)
      expect(response.body).toEqual({
        token,
        message: 'Login successful',
        user: {
          email: 'test@example.com',
          id: 1,
        },
      })
    })

    it('should return 401 if email is incorrect', async () => {
      prismaMock.user.findUnique.mockResolvedValue(null)

      const response = await request(app).post('/users/login').send({
        email: 'wrong@example.com',
        password: 'truePassword',
      })

      expect(response.status).toBe(401)
      expect(response.body).toEqual({
        error: 'Email not found',
      })
    })

    it('should return 401 if password is incorrect', async () => {
      const user = {
        id: 1,
        email: 'test@example.com',
        password: await bcrypt.hash('password123', 10),
      }

      prismaMock.user.findUnique.mockResolvedValue(user)

      const response = await request(app).post('/users/login').send({
        email: 'test@example.com',
        password: 'wrongpassword',
      })

      expect(response.status).toBe(401)
      expect(response.body).toEqual({
        error: 'Invalid password',
      })
    })

    it('should return 500 if login fails', async () => {
      prismaMock.user.findUnique.mockRejectedValue(new Error('Database error'))

      const response = await request(app).post('/users/login').send({
        email: 'test@example.com',
        password: 'truePassword',
      })

      expect(response.status).toBe(500)
      expect(response.body).toEqual({
        error: 'Failed to login',
      })
    })
  })
})
