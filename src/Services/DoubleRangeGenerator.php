<?php

namespace App\Services;

/*
 * @description : genrer des double range . gerez les boutons en JavaScript
 *
 */
class DoubleRangeGenerator
{
    private $minValue;
    private $maxValue;
    private $step;
    private $defaultMinSelected;
    private $defaultMaxSelected;
    private $rangeName;
    private $rangeId;

    /**
     * Constructeur de la classe DoubleRangeGenerator
     *
     * @param int|float $minValue Valeur minimum du range
     * @param int|float $maxValue Valeur maximum du range
     * @param int|float $step Pas du range
     * @param int|float $defaultMinSelected Valeur minimum sélectionnée par défaut
     * @param int|float $defaultMaxSelected Valeur maximum sélectionnée par défaut
     * @param string $rangeName Nom du range (pour les formulaires)
     * @param string $rangeId ID du range (pour le DOM)
     */
    public function __construct(
        $minValue = 0,
        $maxValue = 100,
        $step = 1,
        $defaultMinSelected = 25,
        $defaultMaxSelected = 75,
        $rangeName = 'double-range',
        $rangeId = 'double-range'
    )
    {
        $this->minValue = $minValue;
        $this->maxValue = $maxValue;
        $this->step = $step;
        $this->defaultMinSelected = $defaultMinSelected;
        $this->defaultMaxSelected = $defaultMaxSelected;
        $this->rangeName = $rangeName;
        $this->rangeId = $rangeId;
    }

    /**
     * Génère le HTML pour le double range
     *
     * @return string Le HTML du double range
     */
    public function generateHTML()
    {
        $output = '<div class="double-range-container" id="' . htmlspecialchars($this->rangeId) . '-container">';
        //  label ragen
        $output .= '<div class="titre">'. htmlspecialchars($this->rangeName). '</div>';
        // Entrées pour les valeurs
        $output .= '<div class="double-range-inputs">';
        $output .= '<input type="number" id="' . htmlspecialchars($this->rangeId) . '-min-value" 
                    name="' . htmlspecialchars($this->rangeName) . '-min" 
                    value="' . htmlspecialchars($this->defaultMinSelected) . '" 
                    min="' . htmlspecialchars($this->minValue) . '" 
                    max="' . htmlspecialchars($this->maxValue) . '" 
                    step="' . htmlspecialchars($this->step) . '">';

        $output .= '<input type="number" id="' . htmlspecialchars($this->rangeId) . '-max-value" 
                    name="' . htmlspecialchars($this->rangeName) . '-max" 
                    value="' . htmlspecialchars($this->defaultMaxSelected) . '" 
                    min="' . htmlspecialchars($this->minValue) . '" 
                    max="' . htmlspecialchars($this->maxValue) . '" 
                    step="' . htmlspecialchars($this->step) . '">';
        $output .= '</div>';

        // Conteneur pour les sliders
        $output .= '<div class="double-range-sliders">';
        $output .= '<div class="double-range-track"></div>';
        $output .= '<div class="double-range-progress"></div>';

        // Slider min
        $output .= '<input type="range" id="' . htmlspecialchars($this->rangeId) . '-min" 
                    value="' . htmlspecialchars($this->defaultMinSelected) . '" 
                    min="' . htmlspecialchars($this->minValue) . '" 
                    max="' . htmlspecialchars($this->maxValue) . '" 
                    step="' . htmlspecialchars($this->step) . '">';

        // Slider max
        $output .= '<input type="range" id="' . htmlspecialchars($this->rangeId) . '-max" 
                    value="' . htmlspecialchars($this->defaultMaxSelected) . '" 
                    min="' . htmlspecialchars($this->minValue) . '" 
                    max="' . htmlspecialchars($this->maxValue) . '" 
                    step="' . htmlspecialchars($this->step) . '">';

        $output .= '</div>';
        $output .= '<div class="bouton_position">';
        $output .= '<button class="btnTrie" id="' . htmlspecialchars($this->rangeId) .'" onClick="btn' .htmlspecialchars($this->rangeId). '()"> Triez par '. htmlspecialchars($this->rangeName) .'</button>';
        $output .= '</div>';
        $output .= '</div>';

        // JavaScript pour gérer les interactions
        $output .= $this->generateJavaScript();

        // CSS pour le style
        $output .= $this->generateCSS();

        return $output;
    }

    /**
     * Génère le JavaScript nécessaire pour le fonctionnement du double range
     *
     * @return string Le code JavaScript
     */
    private function generateJavaScript()
    {
        $jsCode = '<script>
        document.addEventListener("DOMContentLoaded", function() {
            const minSlider = document.getElementById("' . $this->rangeId . '-min");
            const maxSlider = document.getElementById("' . $this->rangeId . '-max");
            const minInput = document.getElementById("' . $this->rangeId . '-min-value");
            const maxInput = document.getElementById("' . $this->rangeId . '-max-value");
            const progressBar = document.querySelector("#' . $this->rangeId . '-container .double-range-progress");
            
            // Fonction pour mettre à jour la barre de progression
            function updateProgressBar() {
                const minVal = parseFloat(minSlider.value);
                const maxVal = parseFloat(maxSlider.value);
                const minPos = ((minVal - ' . $this->minValue . ') / (' . $this->maxValue . ' - ' . $this->minValue . ')) * 100;
                const maxPos = ((maxVal - ' . $this->minValue . ') / (' . $this->maxValue . ' - ' . $this->minValue . ')) * 100;
                
                progressBar.style.left = minPos + "%";
                progressBar.style.width = (maxPos - minPos) + "%";
            }
            
            // Initialisation
            updateProgressBar();
            
            // Gestion des évènements du slider min
            minSlider.addEventListener("input", function() {
                const minVal = parseFloat(minSlider.value);
                const maxVal = parseFloat(maxSlider.value);
                
                if (minVal > maxVal) {
                    minSlider.value = maxVal;
                }
                
                minInput.value = minSlider.value;
                updateProgressBar();
            });
            
            // Gestion des évènements du slider max
            maxSlider.addEventListener("input", function() {
                const minVal = parseFloat(minSlider.value);
                const maxVal = parseFloat(maxSlider.value);
                
                if (maxVal < minVal) {
                    maxSlider.value = minVal;
                }
                
                maxInput.value = maxSlider.value;
                updateProgressBar();
            });
            
            // Gestion des évènements des inputs
            minInput.addEventListener("change", function() {
                const minVal = parseFloat(minInput.value);
                const maxVal = parseFloat(maxSlider.value);
                
                if (minVal < ' . $this->minValue . ') {
                    minInput.value = ' . $this->minValue . ';
                } else if (minVal > maxVal) {
                    minInput.value = maxVal;
                }
                
                minSlider.value = minInput.value;
                updateProgressBar();
            });
            
            maxInput.addEventListener("change", function() {
                const minVal = parseFloat(minSlider.value);
                const maxVal = parseFloat(maxInput.value);
                
                if (maxVal > ' . $this->maxValue . ') {
                    maxInput.value = ' . $this->maxValue . ';
                } else if (maxVal < minVal) {
                    maxInput.value = minVal;
                }
                
                maxSlider.value = maxInput.value;
                updateProgressBar();
            });
        });
        </script>';

        return $jsCode;
    }

    /**
     * Génère le CSS pour le style du double range
     *
     * @return string Le code CSS
     */
    private function generateCSS()
    {
        $cssCode = '<style>
        .double-range-container {
            width: 100%;
            padding: 20px 0;
        }
        
        div.titre {
            font-weight: bold;
            text-align: center;
            margin-bottom: 2px;
        }
        .bouton_position{
            display: flex;
            justify-content: flex-end;
        }
        
        button.btnTrie{
        
            background-color: #212529;
            font-size: 1rem;
            color: #fff;
            border-radius: 5px;
            
        }
        button.btnTrie:hover{
            background-color: #424649;
        }
        
        .double-range-inputs {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .double-range-inputs input {
            width: 80px;
            padding: 5px;
            text-align: center;
        }
        
        .double-range-sliders {
            position: relative;
            height: 40px;
        }
        
        .double-range-track {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            height: 4px;
            background-color: #ddd;
            border-radius: 2px;
        }
        
        .double-range-progress {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            height: 4px;
            background-color: red;
            border-radius: 2px;
        }
        
        .double-range-sliders input[type="range"] {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            height: 0;
            -webkit-appearance: none;
            pointer-events: none;
            background: transparent;
        }
        
        .double-range-sliders input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            pointer-events: auto;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background-color: red;
            cursor: pointer;
        }
        
        .double-range-sliders input[type="range"]::-moz-range-thumb {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background-color: red;
            cursor: pointer;
            border: none;
        }
        </style>';

        return $cssCode;
    }

    /**
     * Affiche le double range
     */
    public function render()
    {
       echo $this->generateHTML();
    }
}
