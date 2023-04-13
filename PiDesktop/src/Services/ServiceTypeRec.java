/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Services;

import Entities.type_reclamation;
import Utils.myDB;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author EMNA
 */
public class ServiceTypeRec implements IService<type_reclamation>{
        Connection cnx;
    
    public  ServiceTypeRec(){
        cnx =myDB.getInstance().getCnx();
    }
    @Override
    public void ajouter(type_reclamation t) {
        try {
            String qry = "INSERT INTO `type_reclamation`( `nom`) VALUES (?)";
            PreparedStatement ps = cnx.prepareStatement(qry);
            ps.setString(1, t.getNom());

            ps.executeUpdate();
            System.out.println("ajout type reclamation réussit ");
        } catch (SQLException ex) {
            System.out.println("erreur d'ajout type reclamation");

            System.out.println(ex.getMessage());
        }

    }

    @Override
    public List<type_reclamation> afficher() {
      List<type_reclamation> type_reclamation = new ArrayList<>();
         
        try {
             String req ="SELECT * FROM `type_reclamation` ";
            
            Statement st = cnx.createStatement();
            ResultSet rs= st.executeQuery(req);
            while (rs.next()){
                type_reclamation t = new type_reclamation();
                t.setId(rs.getInt(1));
                t.setNom(rs.getString("nom"));
                type_reclamation.add(t);
            }
         } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }

   return type_reclamation;    }

    @Override
    public void modifier(type_reclamation t) {
    try {
           String req = " UPDATE `type_reclamation` SET `id` = '" +t.getId()+ "', `Nom` = '" +t.getNom()  + "' WHERE `type_reclamation`.`id` = " + t.getId();

            Statement st = cnx.createStatement();
            st.executeUpdate(req);
            System.out.println("type reclamation updated!");
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
    }

   @Override
    public void supprimer(int id) {
        try {
            String req = "DELETE FROM `type_reclamation` WHERE id = " + id;
            Statement st = cnx.createStatement();
            st.executeUpdate(req);
            System.out.println("type reclamation deleted !");
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
    }
}
