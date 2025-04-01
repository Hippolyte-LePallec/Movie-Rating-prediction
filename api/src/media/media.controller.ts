import { Request, Response } from 'express'
import prisma from '../client'

export const getMedia = async (req: Request, res: Response) => {
  try {
    const media = await prisma.media.findMany()
    res.status(200).send(media)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const getMediaById = async (req: Request, res: Response) => {
  try {
    const media = await prisma.media.findUnique({
      where: {
        id_media: parseInt(req.params.id_media),
      },
    })
    res.status(200).send(media)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const createMedia = async (req: Request, res: Response) => {
  try {
    const media = await prisma.media.create({
      data: req.body,
    })
    res.status(201).send(media)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const updateMedia = async (req: Request, res: Response) => {
  try {
    const media = await prisma.media.update({
      where: {
        id_media: parseInt(req.params.id_media),
      },
      data: req.body,
    })
    res.status(200).send(media)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const deleteMedia = async (req: Request, res: Response) => {
  try {
    const media = await prisma.media.delete({
      where: {
        id_media: parseInt(req.params.id_media),
      },
    })
    res.status(204).send([])
  } catch(error) {
    res.status(500).send({error: error})
  }
}
