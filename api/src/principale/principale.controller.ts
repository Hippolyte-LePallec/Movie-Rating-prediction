import { Request, Response } from 'express'
import prisma from '../client'

export const getPrincipals = async (req: Request, res: Response) => {
  try {
    const principals = await prisma.principal.findMany({
      include: {
        media: true,
        personne: true
      }
    })
    res.status(200).send(principals)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const getPrincipalsByMediaId = async (req: Request, res: Response) => {
  try {
    const { mediaId } = req.params
    
    const principals = await prisma.principal.findMany({
      where: {
        mediaId: parseInt(mediaId)
      },
      include: {
        personne: true
      }
    })
    
    res.status(200).send(principals)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const getPrincipalsByPersonneId = async (req: Request, res: Response) => {
  try {
    const { personneId } = req.params
    
    const principals = await prisma.principal.findMany({
      where: {
        personneId: parseInt(personneId)
      },
      include: {
        media: true
      }
    })
    
    res.status(200).send(principals)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const createPrincipal = async (req: Request, res: Response) => {
  try {
    const { mediaId, personneId, ordering, job, characters } = req.body
    
    if (!mediaId || !personneId || ordering === undefined) res.status(400).send({error: "mediaId, personneId et ordering sont requis"})
    
    const mediaExists = await prisma.media.findUnique({
      where: { id_media: mediaId }
    })
    
    const personneExists = await prisma.personne.findUnique({
      where: { id_name: personneId }
    })
    
    if (!mediaExists || !personneExists) res.status(404).send({error: "Média ou personne non trouvé"})
    
    const existingPrincipal = await prisma.principal.findUnique({
      where: {
        mediaId_personneId: {
          mediaId: mediaId,
          personneId: personneId
        }
      }
    })
    
    if (existingPrincipal) res.status(409).send({error: "Cette relation principal existe déjà"})
    
    const principal = await prisma.principal.create({
      data: {
        mediaId,
        personneId,
        ordering,
        job,
        characters
      },
      include: {
        media: true,
        personne: true
      }
    })
    
    res.status(201).send(principal)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const updatePrincipal = async (req: Request, res: Response) => {
  try {
    const { mediaId, personneId } = req.params
    const { ordering, job, characters } = req.body
    
    const existingPrincipal = await prisma.principal.findUnique({
      where: {
        mediaId_personneId: {
          mediaId: parseInt(mediaId),
          personneId: parseInt(personneId)
        }
      }
    })
    
    if (!existingPrincipal) res.status(404).send({error: "Relation principal non trouvée"})
    
    const principal = await prisma.principal.update({
      where: {
        mediaId_personneId: {
          mediaId: parseInt(mediaId),
          personneId: parseInt(personneId)
        }
      },
      data: {
        ordering,
        job,
        characters
      },
      include: {
        media: true,
        personne: true
      }
    })
    
    res.status(200).send(principal)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const deletePrincipal = async (req: Request, res: Response) => {
  try {
    const { mediaId, personneId } = req.params
    
    const existingPrincipal = await prisma.principal.findUnique({
      where: {
        mediaId_personneId: {
          mediaId: parseInt(mediaId),
          personneId: parseInt(personneId)
        }
      }
    })
    
    if (!existingPrincipal) res.status(404).send({error: "Relation principal non trouvée"})
    
    const principal = await prisma.principal.delete({
      where: {
        mediaId_personneId: {
          mediaId: parseInt(mediaId),
          personneId: parseInt(personneId)
        }
      }
    })
    
    res.status(200).send(principal)
  } catch(error) {
    res.status(500).send({error: error})
  }
}