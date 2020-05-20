package com.example.david.buscaminas;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.Dialog;
import android.app.DialogFragment;
import android.content.DialogInterface;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.preference.PreferenceManager;

/**
 * Created by David on 16/11/2017.
 */

public class Dialogos extends DialogFragment {
    // Instanciamos  la interfaz para poder controlar los eventos entre los dialogos y el activity principal:
    RespuestaDialogoOpciones respuesta;

    String dificultad;

    //metodo para conseguir la dificultad
    public void dameDificultad(String dificultad){
        this.dificultad=dificultad;



    }

    //main

    /**
     * Método que se ejecuta cuando la actividad principal ejecuta el show()
     * Cuando el usuario selecciona una opción, se desencadena la llamada la funcion
     * de callback onRespuesta y se cierra el dialogo
     * @param savedInstanceState
     * @return
     */
    @Override
    public Dialog onCreateDialog(Bundle savedInstanceState) {

        // Usamos la clase Builder para construir el diálogo
        AlertDialog.Builder builder = new AlertDialog.Builder(getActivity());
        //Escribimos el título
        builder.setTitle("Dificultad en el juego");
        // Creamos un array de char para los diferentes RadioButtons:
        final CharSequence[] items = new CharSequence[3];

        items[0] = "Fácil";
        items[1] = "Normal";
        items[2] = "Difícil";
        // Establecemos el título:
          builder.setTitle("Dificultad en el juego");


        int modo= Integer.parseInt(dificultad);

        // Establecemos una selección simple, pasandole el array de elementos,el elemento por defecto y el evento:
        builder.setSingleChoiceItems(items,modo, new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int elementoSeleccionado) {
                // Al seleccionar un elemento pasamos el elemento seleccionado al método de la interfaz onRespuesta:
                respuesta.respuestaDificultad(elementoSeleccionado);
                // Cerramos el dialogo:
                dialog.dismiss();
            }

        });

        // Creamos el AlertDialog y lo devolvemos:
        return builder.create();
    }

    /**
     * Interfaz que contiene el método onRespuesta que implementaremos
     * en la clase que lo usemos:
     */
    public interface RespuestaDialogoOpciones {
        public void respuestaDificultad(int elementoSeleccionado);
    }

    /**
     * Permite unir la actividad principal a la interfaz
     * @param activity
     */
    @Override
    public void onAttach(Activity activity) {
        super.onAttach(activity);

        try {
            respuesta = (RespuestaDialogoOpciones) activity;

        } catch (ClassCastException e) {
            throw new ClassCastException(
                    activity.toString() +
                            " no implementó OnSimpleDialogListener");

        }
    }
}
