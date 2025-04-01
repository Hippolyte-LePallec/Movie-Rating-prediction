import { Request, Response } from 'express'
import prisma from '../client'

export const getGenre = async (req: Request, res: Response) => {
  try {
    const genre = await prisma.genre.findMany()
    res.status(200).send(genre)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const getGenreById = async (req: Request, res: Response) => {
  try {
    const genre = await prisma.genre.findUnique({
      where: {
        id_genre: parseInt(req.params.id_genre),
      },
    })
    res.status(200).send(genre)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const createGenre = async (req: Request, res: Response) => {
  try {
    const genre = await prisma.genre.create({
      data: req.body,
    })
    res.status(201).send(genre)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const updateGenre = async (req: Request, res: Response) => {
  try {
    const genre = await prisma.genre.update({
      where: {
        id_genre: parseInt(req.params.id_genre),
      },
      data: req.body,
    })
    res.status(200).send(genre)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const deleteGenre = async (req: Request, res: Response) => {
  try {
    const genre = await prisma.genre.delete({
      where: {
        id_genre: parseInt(req.params.id_genre),
      },
    })
    res.status(204).send([])
  } catch(error) {
    res.status(500).send({error: error})
  }
}
