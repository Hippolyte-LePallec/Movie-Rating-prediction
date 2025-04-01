import { Request, Response } from 'express'
import prisma from '../client'

export const getPersonne = async (req: Request, res: Response) => {
  try {
    const personne = await prisma.personne.findMany()
    res.status(200).send(personne)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const getPersonneById = async (req: Request, res: Response) => {
  try {
    const personne = await prisma.personne.findUnique({
      where: {
        id_name: parseInt(req.params.id_name),
      },
    })
    res.status(200).send(personne)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const createPersonne = async (req: Request, res: Response) => {
  try {
    const personne = await prisma.personne.create({
      data: req.body,
    })
    res.status(201).send(personne)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const updatePersonne = async (req: Request, res: Response) => {
  try {
    const personne = await prisma.personne.update({
      where: {
        id_name: parseInt(req.params.id_name),
      },
      data: req.body,
    })
    res.status(200).send(personne)
  } catch(error) {
    res.status(500).send({error: error})
  }
}

export const deletePersonne = async (req: Request, res: Response) => {
  try {
    const personne = await prisma.personne.delete({
      where: {
        id_name: parseInt(req.params.id_name),
      },
    })
    res.status(203).send([])
  } catch(error) {
    res.status(500).send({error: error})
  }
}