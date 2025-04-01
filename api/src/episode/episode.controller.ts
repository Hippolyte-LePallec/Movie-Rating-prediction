import { Request, Response } from 'express'
import prisma from '../client'

export const getEpisode = async (req: Request, res: Response) => {
  try {
    const episode = await prisma.episode.findMany()
    res.status(200).send(episode)
  } catch(error) {
    res.status(500).send({error: error})
  }
}   

export const getEpisodeById = async (req: Request, res: Response) => {
  try {
    const episode = await prisma.episode.findUnique({
      where: {
        id_episode: parseInt(req.params.id_episode),
      },
    })
    res.status(200).send(episode)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const createEpisode = async (req: Request, res: Response) => {
  try {
    const episode = await prisma.episode.create({
      data: req.body,
    })
    res.status(201).send(episode)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const updateEpisode = async (req: Request, res: Response) => {
  try {
    const episode = await prisma.episode.update({
      where: {
        id_episode: parseInt(req.params.id_episode),
      },
      data: req.body,
    })
    res.status(200).send(episode)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const deleteEpisode = async (req: Request, res: Response) => {
  try {
    const episode = await prisma.episode.delete({
      where: {
        id_episode: parseInt(req.params.id_episode),
      },
    })
    res.status(204).send([])
  } catch(error) {
    res.status(500).send({error: error})
  }
}