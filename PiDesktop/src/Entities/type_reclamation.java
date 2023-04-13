/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Entities;

/**
 *
 * @author EMNA
 */
public class type_reclamation {
    private int id;
    private String nom;

    public type_reclamation(int id, String nom) {
        this.id = id;
        this.nom = nom;
    }

    public type_reclamation() {
    }
    

    public type_reclamation(String nom) {
        this.nom = nom;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getNom() {
        return nom;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    @Override
    public String toString() {
        return "type_reclamation{" + "id=" + id + ", nom=" + nom + "\n";
    }
    
    
}
