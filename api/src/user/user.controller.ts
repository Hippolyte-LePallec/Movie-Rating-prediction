import { Request, Response } from 'express'
import prisma from '../client'
import jwt from 'jsonwebtoken'
import bcrypt from 'bcrypt'

export const fetchUser = async (req: Request, res: Response) => {
  try {
    const userId = req.params.userId
    const user = await prisma.user.findUnique({
      where: {
        id: parseInt(userId),
      },
    })
    res.status(200).send(user)
  } catch {
    res.status(500).json({
      error: 'Failed to fetch users',
    })
  }
}

export const createUser = async (req: Request, res: Response) => {
  const { email, password } = req.body
  const user = await prisma.user.findUnique({
    where: {
      email,
    },
  })

  if (user) {
    res.status(401).json({
      error: 'Email already exists',
    })
    return
  }
  try {
    const hashedPassword = await bcrypt.hash(password, 10)
    const user = await prisma.user.create({
      data: {
        email,
        password: hashedPassword,
      },
    })
    res.status(201).send(user)
  } catch {
    res.status(500).send({
      error: 'Failed to create user',
    })
  }
}

export const login = async (req: Request, res: Response) => {
  const { email, password } = req.body

  try {
    const user = await prisma.user.findUnique({
      where: {
        email,
      },
    })

    if (!user) {
      res.status(401).json({
        error: 'Email not found',
      })
      return
    }

    const isPasswordValid = await bcrypt.compare(password, user.password)
    if (!isPasswordValid) {
      res.status(401).json({
        error: 'Invalid password',
      })
      return
    }

    const token = jwt.sign(
      {
        userId: user.id,
        email: user.email,
      },
      process.env.JWT_SECRET as jwt.Secret,
      {
        expiresIn: process.env.JWT_EXPIRES_IN,
      },
    )

    res.status(200).json({
      token,
      user: {
        id: user.id,
        email: user.email,
      },
      message: 'Login successful',
    })
  } catch {
    res.status(500).json({
      error: 'Failed to login',
    })
  }
}
