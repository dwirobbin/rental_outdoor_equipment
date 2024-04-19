<div class="d-flex align-items-center" style="margin: 0 .94rem;">
    <style>
        .toggle {
            --width: 58.8px;
            --height: calc(var(--width) / 2.1);
            position: relative;
            display: inline-block;
            width: var(--width);
            height: var(--height);
            box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);
            border-radius: var(--height);
            cursor: pointer;
        }

        .toggle input {
            display: none;
        }

        .toggle .slider {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: var(--height);
            background-color: #ccc;
            transition: all 0.4s ease-in-out;
        }

        .toggle .slider::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: calc(var(--height));
            height: calc(var(--height));
            border-radius: calc(var(--height) / 2);
            background-color: #fff;
            box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);
            transition: all 0.4s ease-in-out;
        }

        .toggle input:checked+.slider {
            background-color: #3bdc01;
        }

        .toggle input:checked+.slider::before {
            transform: translateX(calc(var(--width) - var(--height)));
        }

        .toggle .labels {
            position: absolute;
            top: 6px;
            left: 0;
            width: 100%;
            height: 100%;
            font-size: 11.5px;
            font-family: sans-serif;
            transition: all 0.4s ease-in-out;
            overflow: hidden;
        }

        .toggle .labels::after {
            content: attr(data-off);
            position: absolute;
            right: 5px;
            color: #4d4d4d;
            opacity: 1;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.4);
            transition: all 0.4s ease-in-out;
        }

        .toggle .labels::before {
            content: attr(data-on);
            position: absolute;
            left: calc(var(--height) - var(--width) + 7px);
            color: #ffffff;
            opacity: 0;
            text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.4);
            transition: all 0.4s ease-in-out;
        }

        .toggle input:checked~.labels::after {
            opacity: 0;
            transform: translateX(calc(var(--width) - var(--height)));
        }

        .toggle input:checked~.labels::before {
            opacity: 1;
            transform: translateX(calc(var(--width) - var(--height)));
        }
    </style>

    <label class="toggle">
        <input type="checkbox" wire:model.live='isActive'>
        <span class="slider"></span>
        <span class="labels" data-on="ON" data-off="OFF"></span>
    </label>
</div>
