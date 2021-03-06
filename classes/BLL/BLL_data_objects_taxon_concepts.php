<?php


class BLL_data_objects_taxon_concepts {
	
	 static function Insert_data_objects_taxon_concepts($DB, $taxon_concept_id, $data_object_id) 
	 {
	 	 $con = new PDO_Connection();
	  	 $con->Open($DB);		  	
	  	 $query = $con->connection->prepare("INSERT INTO  data_objects_taxon_concepts VALUES(?,?);");
	  	 $query->bindParam(1, $taxon_concept_id);	 	
	  	 $query->bindParam(2, $data_object_id);	 		 	
	     $query->execute();
		 $con->Close();            
	}
	
 	static function Select_data_objects_taxon_concepts_By_TaxonConceptID($DB, $taxon_concept_id) 
	{
	 	 $con = new PDO_Connection();
	  	 $con->Open($DB);		  	
	  	 $query = $con->connection->prepare("SELECT * FROM data_objects_taxon_concepts WHERE taxon_concept_id=?;");
	  	 $query->bindParam(1, $taxon_concept_id);	 	
	     $query->execute();		
		 $records = $query->fetchAll(PDO::FETCH_CLASS, 'DAL_data_objects_taxon_concepts');
		 $con->Close();    
		 return  $records;	        
	}
	
	static function Select_data_objects_taxon_concepts_By_DataObjectID($DB, $data_object_id) 
	{
	 	 $con = new PDO_Connection();
	  	 $con->Open($DB);		  	
	  	 $query = $con->connection->prepare("SELECT * FROM data_objects_taxon_concepts WHERE data_object_id=?;");
	  	 $query->bindParam(1, $data_object_id);	 	
	     $query->execute();		
		 $records = $query->fetchAll(PDO::FETCH_CLASS, 'DAL_data_objects_taxon_concepts');
		 $con->Close();    
		 return  $records;	        
	}
	
	static function Exist_data_objects_taxon_concepts($DB, $data_object_id, $taxon_concept_id) 
	{
	 	 $con = new PDO_Connection();
	  	 $con->Open($DB);		  	
	  	 $query = $con->connection->prepare("SELECT COUNT(*) FROM data_objects_taxon_concepts WHERE data_object_id=? AND taxon_concept_id=?;");
	  	 $query->bindParam(1, $data_object_id);	 	
	  	 $query->bindParam(2, $taxon_concept_id);
	     $query->execute();		
		 $results = $query->fetchColumn();
		 $con->Close();    
		 return  $results;	        
	}
	
	static function Select_taxons_incommon_ByTaxon_ID($DB, $taxon_concept_id) 
	{
	 	 $con = new PDO_Connection();
	  	 $con->Open($DB);		  	
	  	 $query = $con->connection->prepare("
		  	 SELECT distinct taxon_concept_id 
		  	 FROM data_objects_taxon_concepts 
		  	 WHERE data_object_id IN(
		  	 	SELECT data_object_id FROM data_objects_taxon_concepts WHERE taxon_concept_id=?
		  	 );");
	  	 $query->bindParam(1, $taxon_concept_id);	 	
	     $query->execute();		
		 $records = $query->fetchAll(PDO::FETCH_CLASS, 'DAL_data_objects_taxon_concepts');
		 $con->Close();    
		 return  $records;	        
	}	
}

?>