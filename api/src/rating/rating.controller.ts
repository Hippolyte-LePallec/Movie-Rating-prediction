import { Request, Response } from 'express'
import prisma from '../client'

export const getRating = async (req: Request, res: Response) => {
  try {
    const rating = await prisma.rating.findMany()
    res.status(200).send(rating)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const getRatingById = async (req: Request, res: Response) => {
  try {
    const rating = await prisma.rating.findUnique({
      where: {
        id_rating: parseInt(req.params.id_rating),
      },
    })
    res.status(200).send(rating)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const createRating = async (req: Request, res: Response) => {
  try {
    const rating = await prisma.rating.create({
      data: req.body,
    })
    res.status(201).send(rating)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const updateRating = async (req: Request, res: Response) => {
  try {
    const rating = await prisma.rating.update({
      where: {
        id_rating: parseInt(req.params.id_rating),
      },
      data: req.body,
    })
    res.status(200).send(rating)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const deleteRating = async (req: Request, res: Response) => {
  try {
    const rating = await prisma.rating.delete({
      where: {
        id_rating: parseInt(req.params.id_rating),
      },
    })
    res.status(203).send([])
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const getRatingByMedia = async (req: Request, res: Response) => {
  try {
    const rating = await prisma.rating.findMany({
      where: {
        media: {
          id_media: parseInt(req.params.id_media),
        },
      },
    })
    res.status(200).send(rating)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const getRatingByMediaId = async (req: Request, res: Response) => {
  try {
    const rating = await prisma.rating.findMany({
      where: {
        mediaId: parseInt(req.params.id_media),
      },
    })
    res.status(204).send(rating)
  } catch(error) {
    res.status(500).send({error: error})
  }
}