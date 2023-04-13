/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package pidesktop;

import Entities.type_reclamation;
import Services.ServiceReclamation;
import Services.ServiceTypeRec;
import Utils.myDB;

/**
 *
 * @author EMNA
 */
public class PiDesktop {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        myDB mc = new myDB ();
        
       type_reclamation t1 = new type_reclamation("jahjgjkghjghjgjva");
       ServiceTypeRec st = new ServiceTypeRec();
        st.ajouter(t1);
        System.out.println( st.afficher());

       
        ServiceReclamation rec = new ServiceReclamation();
         System.out.println( rec.afficher());
    }
    
}
