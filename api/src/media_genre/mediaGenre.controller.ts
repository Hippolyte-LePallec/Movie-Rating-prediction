import { Request, Response } from 'express'
import prisma from '../client'

export const getMediaGenres = async (req: Request, res: Response) => {
  try {
    const mediaGenres = await prisma.mediaGenre.findMany({
      include: {
        media: true,
        genre: true
      }
    })
    res.status(200).send(mediaGenres)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const createMediaGenre = async (req: Request, res: Response) => {
    try {
      const { mediaId, genreId } = req.body
      
      if (!mediaId || !genreId) res.status(400).send({error: "mediaId et genreId sont requis"})
      
      const mediaExists = await prisma.media.findUnique({
        where: { id_media: mediaId }
      })
      
      const genreExists = await prisma.genre.findUnique({
        where: { id_genre: genreId }
      })
      
      if (!mediaExists || !genreExists) res.status(404).send({error: "Média ou genre non trouvé"})
      
      const existingMediaGenre = await prisma.mediaGenre.findUnique({
        where: {
          mediaId_genreId: {
            mediaId: mediaId,
            genreId: genreId
          }
        }
      })
      
      if (existingMediaGenre) res.status(409).send({error: "Cette association média-genre existe déjà"})
      
      const mediaGenre = await prisma.mediaGenre.create({
        data: {
          mediaId,
          genreId
        },
        include: {
          media: true,
          genre: true
        }
      })
      
      res.status(201).send(mediaGenre)
    } catch(error) {
      res.status(500).send({error: error})
    }
  }

  export const deleteMediaGenre = async (req: Request, res: Response) => {
    try {
      const { mediaId, genreId } = req.params
      
      const mediaGenre = await prisma.mediaGenre.delete({
        where: {
          mediaId_genreId: {
            mediaId: parseInt(mediaId),
            genreId: parseInt(genreId)
          }
        }
      })
      
      res.status(200).send(mediaGenre)
    } catch(error) {
      res.status(500).send({error: error})
    }
  }