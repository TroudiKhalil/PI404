/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Entities;

import java.util.Date;

/**
 *
 * @author EMNA
 */
public class reclamation {
     private int id;
    private int id_usr_id;
    private type_reclamation id_tr_id;
    private Date date;
    private String email;
    private int telephone;
    private String cmnt;
    private String etat;
    
    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getId_usr_id() {
        return id_usr_id;
    }

    public void setId_usr_id(int id_usr_id) {
        this.id_usr_id = id_usr_id;
    }

    public type_reclamation getId_tr_id() {
        return id_tr_id;
    }

    public void setId_tr_id(type_reclamation id_tr_id) {
        this.id_tr_id = id_tr_id;
    }
    
    public Date getDate() {
        return date;
    }

    public void setDate(Date date) {
        this.date = date;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public int getTelephone() {
        return telephone;
    }

    public void setTelephone(int telephone) {
        this.telephone = telephone;
    }

    public String getCmnt() {
        return cmnt;
    }

    public void setCmnt(String cmnt) {
        this.cmnt = cmnt;
    }

    public String getEtat() {
        return etat;
    }

    public void setEtat(String etat) {
        this.etat = etat;
    }


    public reclamation(int id, int id_usr_id, type_reclamation id_tr_id, Date date, String email, int telephone, String cmnt, String etat) {
        this.id = id;
        this.id_usr_id = id_usr_id;
        this.id_tr_id = id_tr_id;
        this.date = date;
        this.email = email;
        this.telephone = telephone;
        this.cmnt = cmnt;
        this.etat = etat;
    }
    public reclamation(){
    }

    public reclamation(int id, int id_usr_id, Date date, String email, int telephone, String cmnt, String etat) {
        this.id = id;
        this.id_usr_id = id_usr_id;
        this.date = date;
        this.email = email;
        this.telephone = telephone;
        this.cmnt = cmnt;
        this.etat = etat;
    }

    public reclamation(int id_usr_id, type_reclamation id_tr_id, Date date, String email, int telephone, String cmnt, String etat) {
        this.id_usr_id = id_usr_id;
        this.id_tr_id = id_tr_id;
        this.date = date;
        this.email = email;
        this.telephone = telephone;
        this.cmnt = cmnt;
        this.etat = etat;
    }

    @Override
    public String toString() {
        return "reclamation{" + "id=" + id + ", id_usr_id=" + id_usr_id + ", type_reclamation=" + id_tr_id + ", date=" + date + ", email=" + email + ", telephone=" + telephone + ", cmnt=" + cmnt + ", etat=" + etat + "\n";
    }


    
}
