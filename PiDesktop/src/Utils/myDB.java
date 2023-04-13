/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Utils;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

/**
 *
 * @author EMNA
 */
public class myDB {
    final String URL ="jdbc:mysql://127.0.0.1:3306/pi";
   final String USERNAME ="root";
   final String PWD ="";
    private static myDB instance ;
    private Connection cnx;
    public myDB(){
       try {
            cnx = DriverManager.getConnection(URL, USERNAME, PWD);
           System.out.println("connexion réussite!");
       
       } catch (SQLException ex) {
           System.out.println(ex.getMessage()); 
       }
    }
    
    public static myDB getInstance (){
        if (instance == null)
            instance =new myDB();
        return instance;
    }

    public Connection getCnx() {
        return cnx;
    }
}
