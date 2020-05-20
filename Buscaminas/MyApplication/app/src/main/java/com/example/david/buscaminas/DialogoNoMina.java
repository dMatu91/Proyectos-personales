package com.example.david.buscaminas;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.Dialog;
import android.app.DialogFragment;
import android.content.DialogInterface;
import android.os.Bundle;

/**
 * Created by David on 15/11/2017.
 */

public class DialogoNoMina extends DialogFragment {


    //Instancia de la interfaz
    DialogoNoMina.RespuestaDialogoMina respuesta;

    /**
     * Método que se ejecuta cuando la actividad principal ejecuta el show()
     * Cuando el usuario pulsa si o no, se desencadena la llamada la funcion
     * de callback onRespuesta
     * @param savedInstanceState
     * @return
     */
    @Override

    public Dialog onCreateDialog(Bundle savedInstanceState) {

        // Usamos la clase Builder para construir el diálogo
        AlertDialog.Builder builder = new AlertDialog.Builder(getActivity());
        //Escribimos el título
        builder.setTitle("AHÍ NO HABIA NINGUNA MINA, HAS PERDIDO");
        //Escribimos la pregunta
        builder.setMessage("¿Quieres volver a jugar?");
        //añadimos el botón de Si y su acción asociada
        builder.setPositiveButton("¡SI!", new DialogInterface.OnClickListener() {
            public void onClick(DialogInterface dialog, int id) {
                respuesta.onRespuesta(true);
            }
        });
        //añadimos el botón de No y su acción asociada
        builder.setNegativeButton("¡NO!", new DialogInterface.OnClickListener() {
            public void onClick(DialogInterface dialog, int id) {
                respuesta.onRespuesta(false);
            }
        });
        // Crear el AlertDialog y devolverlo
        return builder.create();
    }

    /**
     * Interfaz que contiene el método onRespuesta que implementaremos
     * en la clase que lo usemos
     */
    public interface RespuestaDialogoMina{
        public void onRespuesta(boolean s);
    }

    /**
     * Permite unir la actividad principal a la interfaz
     * @param activity
     */
    @Override
    public void onAttach(Activity activity) {
        super.onAttach(activity);
        respuesta=(RespuestaDialogoMina) activity;
    }

}
