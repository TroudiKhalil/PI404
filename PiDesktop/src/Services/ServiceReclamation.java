/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Services;

import Entities.reclamation;
import Utils.myDB;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.sql.Timestamp;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
/**
 *
 * @author EMNA
 */
public class ServiceReclamation implements IService<reclamation>{
        Connection cnx;
    
    public  ServiceReclamation(){
        cnx =myDB.getInstance().getCnx();
    }


    @Override
    public void ajouter(reclamation r) {
 try {
            String qry = "INSERT INTO `reclamation`( `id_usr_id`,`date`,`email`,`telephone`) VALUES (?,?,?,?)";
            PreparedStatement ps = cnx.prepareStatement(qry);
            ps.setInt(1, r.getId_usr_id());
 //           ps.setString(2, getId_tr_id());
            ps.setTimestamp(3, (Timestamp) r.getDate());
            ps.setString(4, r.getEmail());
            ps.setInt(5, r.getTelephone());
            ps.setString(6, r.getCmnt());
            ps.setString(7, r.getEtat());
            ps.executeUpdate();
            System.out.println("succès ");
        } catch (SQLException ex) {
            System.out.println("erreur ");

            System.out.println(ex.getMessage());
        }    }

    @Override
    public List<reclamation> afficher() {
              List<reclamation>reclamation = new ArrayList<>();

    try {
             String req ="SELECT * FROM `reclamation` ";
            
            Statement st = cnx.createStatement();
            ResultSet rs= st.executeQuery(req);
            while (rs.next()){
                reclamation r = new reclamation();
                r.setId(rs.getInt(1));
                r.setId_usr_id(rs.getInt(2));
  //              r.setId_tr_id(rs.getInt(3));
                r.setDate(rs.getTimestamp(4));
                r.setEmail(rs.getString(5));
                r.setTelephone(rs.getInt(6));
                r.setCmnt(rs.getString(7));
                r.setEtat(rs.getString(8));

                reclamation.add(r);
            }
         } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }   
     return reclamation;}

    @Override
    public void modifier(reclamation r) {
   try {
           String req = " UPDATE `reclamation` SET `id` = '" +r.getId()+ "', `Id_usr_id` = '" +r.getId_usr_id()  +"', `Id_tr_id` = '" +r.getId_tr_id()  +"', `Date` = '" +r.getDate()  +"', `Email` = '" +r.getEmail()  + "', `Telephone` = '" +r.getTelephone()  + "', `cmnt` = '" +r.getCmnt()  +"', `etat` = '" +r.getEtat()  +"' WHERE `reclamation`.`id` = " + r.getId();

            Statement st = cnx.createStatement();
            st.executeUpdate(req);
            System.out.println(" reclamation updated!");
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
    }

    @Override
    public void supprimer(int id) {
try {
            String req = "DELETE FROM `reclamation` WHERE id = " + id;
            Statement st = cnx.createStatement();
            st.executeUpdate(req);
            System.out.println("reclamation supprimée !");
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());
        }
    }

}
