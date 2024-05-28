<template>
    <div>
        <Header></Header>

        <div class="bg-gray-800 text-white pt-20">
            <p class="mx-2 text-lime-300 mb-2 hidden md:block">
              {{ $page.props.pastelitosEvent ? 'Docenas vendidas: ' + $page.props.quantitySold : 'Porciones vendidas: ' + $page.props.quantitySold }}
              <span v-if="!$page.props.pastelitosEvent" class="mx-4">Salsas: {{ totalSauces }}</span>
            </p>
            <div class="pb-2 pl-2 flex justify-between">
              <div class="hidden md:block">
                <input type="text" v-model="search" class="bg-gray-700 rounded-md w-80" placeholder="Buscar por nombre/apellido/tel./direc.">
              </div>
              <div class="flex items-center">
                <p class="mx-2 text-lime-300 hidden md:block" v-if="$page.props.pastelitosEvent">
                  M:{{ totalPortions  }} B:{{ totalBatata }}
                </p>
                <p class="mx-2 text-lime-300 hidden md:block">
                  Ventas: ${{ totalSalesMoney }} Recaudado: ${{ totalMoneyCollected }}
                </p>
                <div class="hidden md:block">
                  <button id="boton-desk" @click="openAssignModal()" class="hidden rounded-md bg-indigo-800 p-2 cursor-pointer text-xl animate__animated animate__fadeIn">
                    Asignar ordenes masivamente
                  </button>
                </div>
                <div @click="openNewOrder()" class="rounded-md bg-green-500 hover:bg-green-400 cursor-pointer p-1 mx-2 hidden md:block md:flex md:items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="#ffffff" d="M11 13H5v-2h6V5h2v6h6v2h-6v6h-2z"/></svg>
                  <p class="text-xl">Agregar orden</p>
                </div>
              </div>
            </div>

            <div class="mb-2 md:hidden space-y-2">
              <p class="mx-2 text-lime-300">
                {{ $page.props.pastelitosEvent ? 'Docenas vendidas: ' + $page.props.quantitySold : 'Porciones vendidas: ' + $page.props.quantitySold }}
                <span v-if="!$page.props.pastelitosEvent" class="mx-4">Salsas: {{ totalSauces }}</span>
              </p>
              <p class="mx-2 text-lime-300" v-if="$page.props.pastelitosEvent">
                M: {{ totalPortions  }} B: {{ totalBatata }}
              </p>
              <p class="mx-2 text-lime-300">
                Ventas: ${{ totalSalesMoney }} Recaudado: ${{ totalMoneyCollected }}
              </p>
              <div @click="openNewOrder()" class="flex items-center rounded-md bg-green-500 hover:bg-green-400 cursor-pointer p-2 mx-2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="#ffffff" d="M11 13H5v-2h6V5h2v6h6v2h-6v6h-2z"/></svg>
                  <p class="text-xl">Agregar orden</p>
              </div>
              <button id="boton" @click="openAssignModal()" class="hidden rounded-md bg-indigo-800 p-2 ml-2 animate__animated animate__fadeIn">
                Asignar ordenes masivamente
              </button>
              <div class="flex justify-center px-2">
                  <input type="text" v-model="search" class="bg-gray-700 rounded-md w-full" placeholder="Buscar por nombre/apellido/tel./direc.">
              </div>
            </div>
            <div  id="table-scroll" class="table-scroll" >
                <table id="main-table" class="main-table">
                    <thead class="bg-gray-900">
                        <tr>
                            <th class="px-4 py-2 border border-gray-600">{{ $page.props.pastelitosEvent ? 'Ventas de:' : 'Rover encargado' }}</th>
                            <th class="px-4 py-2 border border-gray-600">Nombre</th>
                            <th class="px-4 py-2 border border-gray-600">Apellido</th>
                            <th class="px-4 py-2 border border-gray-600">Teléfono</th>
                            <th class="px-4 py-2 border border-gray-600">Dirección</th>
                            <th v-if="!$page.props.pastelitosEvent" class="px-4 py-2 border border-gray-600">Cod. Postal</th>
                            <th v-if="!$page.props.pastelitosEvent" class="px-4 py-2 border border-gray-600">¿Retira?</th>
                            <th class="px-4 py-2 border border-gray-600">{{ $page.props.pastelitosEvent ? '1/2 Membrillo' : 'Cantidad' }}</th>
                            <th v-if="$page.props.pastelitosEvent" class="px-4 py-2 border border-gray-600">1/2 Batata</th>
                            <th v-if="$page.props.pastelitosEvent" class="px-4 py-2 border border-gray-600">Docenas</th>
                            <th class="px-4 py-2 border border-gray-600">Importe</th>
                            <th v-if="!$page.props.pastelitosEvent" class="px-4 py-2 border border-gray-600">Salsas</th>
                            <th class="px-4 py-2 border border-gray-600">Observaciones</th>
                            <th class="px-4 py-2 border border-gray-600">Últ. edición</th>
                            <th class="px-4 py-2 border border-gray-600">Dinero cobrado</th>
                            <th class="px-4 py-2 border border-gray-600">A cobrar</th>
                            <th class="px-4 py-2 border border-gray-600">MP</th>
                            <th class="px-4 py-2 border border-gray-600" style="z-index: 10;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(order, index) in orders" :key="order.id" :class="{'bg-lime-700': order.to_collect === 0 && (order.portions > 0 || order.batata > 0), 'bg-red-700': order.to_collect < 0, 'bg-orange-600': order.to_collect > 0 && (order.portions > 0 || order.batata > 0)}">
                            <th class="px-4 py-2 border border-gray-600" v-if="order.user_id">
                              <div class="w-32 truncate">
                                {{ order.user_name }}
                              </div>
                            </th>
                            <th class="px-4 py-2 border border-gray-600" v-else="order.user_id">-</th>

                            <td @click="startEditing(index, 'name')" class="px-4 py-2 border border-gray-600">
                              <div :id="'name-' + index" :class="{'name': !isEditing(index, 'name'), 'hidden': isEditing(index, 'name') || (loadingName && loadingNameIndex === index)}">
                                {{ order.name }}
                              </div>
                              <input v-show="isEditing(index, 'name')" type="text" v-model="editedName" @blur="stopEditing(index, 'name', order)" @keydown.enter="stopEditing(index, 'name', order)" class="text-black w-full">
                              <div v-if="loadingName && loadingNameIndex === index">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="none" stroke="#ffffff" stroke-dasharray="15" stroke-dashoffset="15" stroke-linecap="round" stroke-width="2" d="M12 3C16.9706 3 21 7.02944 21 12"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.3s" values="15;0"/><animateTransform attributeName="transform" dur="1.5s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12"/></path></svg>
                              </div>
                            </td>

                            <td @click="startEditing(index, 'last_name')" class="px-4 py-2 border border-gray-600">
                              <div :id="'last_name-' + index" :class="{'last_name': !isEditing(index, 'last_name'), 'hidden': isEditing(index, 'last_name') || (loadingLastName && loadingLastNameIndex === index)}" class="w-[128px]">
                                {{ order.last_name }}
                              </div>
                              <input v-show="isEditing(index, 'last_name')" type="text" v-model="editedLastName" @blur="stopEditing(index, 'last_name', order)" @keydown.enter="stopEditing(index, 'last_name', order)" class="text-black w-full">
                              <div v-if="loadingLastName && loadingLastNameIndex === index">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="none" stroke="#ffffff" stroke-dasharray="15" stroke-dashoffset="15" stroke-linecap="round" stroke-width="2" d="M12 3C16.9706 3 21 7.02944 21 12"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.3s" values="15;0"/><animateTransform attributeName="transform" dur="1.5s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12"/></path></svg>
                              </div>
                            </td>

                            <td @click="startEditing(index, 'phone_number')" class="px-4 py-2 border border-gray-600">
                              <div :id="'phone_number-' + index" :class="{'phone_number': !isEditing(index, 'phone_number'), 'hidden': isEditing(index, 'phone_number') || (loadingPhoneNumber && loadingPhoneNumberIndex === index)}" class="w-32">
                                {{ order.phone_number }}
                              </div>
                              <input v-show="isEditing(index, 'phone_number')" type="text" v-model="editedPhoneNumber" @blur="stopEditing(index, 'phone_number', order)" @keydown.enter="stopEditing(index, 'phone_number', order)" class="text-black w-full">
                              <div v-if="loadingPhoneNumber && loadingPhoneNumberIndex === index">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="none" stroke="#ffffff" stroke-dasharray="15" stroke-dashoffset="15" stroke-linecap="round" stroke-width="2" d="M12 3C16.9706 3 21 7.02944 21 12"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.3s" values="15;0"/><animateTransform attributeName="transform" dur="1.5s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12"/></path></svg>
                              </div>
                            </td>

                            <td @click="startEditing(index, 'direction')" class="px-4 py-2 border border-gray-600">
                              <div :id="'direction-' + index" :class="{'direction': !isEditing(index, 'direction'), 'hidden': isEditing(index, 'direction') || (loadingDirection && loadingDirectionIndex === index)}" class="w-32 md:w-44">
                                {{ order.direction }}
                              </div>
                              <input v-show="isEditing(index, 'direction')" type="text" v-model="editedDirection" @blur="stopEditing(index, 'direction', order)" @keydown.enter="stopEditing(index, 'direction', order)" class="text-black w-full">
                              <div v-if="loadingDirection && loadingDirectionIndex === index">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="none" stroke="#ffffff" stroke-dasharray="15" stroke-dashoffset="15" stroke-linecap="round" stroke-width="2" d="M12 3C16.9706 3 21 7.02944 21 12"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.3s" values="15;0"/><animateTransform attributeName="transform" dur="1.5s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12"/></path></svg>
                              </div>
                            </td>

                            <!-- <td class="px-4 py-2 border border-gray-600">{{ order.postal_code }}</td> -->
                            <td v-if="!$page.props.pastelitosEvent" @click="startEditing(index, 'postal_code')" class="px-4 py-2 border border-gray-600">
                              <div :id="'postal_code-' + index" :class="{'postal_code': !isEditing(index, 'postal_code'), 'hidden': isEditing(index, 'postal_code') || (loadingPostalCode && loadingPostalCodeIndex === index)}" class="w-16">
                                {{ order.postal_code }}
                              </div>
                              <input v-show="isEditing(index, 'postal_code')" type="text" v-model="editedPostalCode" @blur="stopEditing(index, 'postal_code', order)" @keydown.enter="stopEditing(index, 'postal_code', order)" class="text-black w-full">
                              <div v-if="loadingPostalCode && loadingPostalCodeIndex === index">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="none" stroke="#ffffff" stroke-dasharray="15" stroke-dashoffset="15" stroke-linecap="round" stroke-width="2" d="M12 3C16.9706 3 21 7.02944 21 12"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.3s" values="15;0"/><animateTransform attributeName="transform" dur="1.5s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12"/></path></svg>
                              </div>
                            </td>

                            <!-- Retira -->
                            <td v-if="!$page.props.pastelitosEvent"  class="px-4 py-2 border border-gray-600">
                              <label :for="'take-away-checkbox-' + order.id" class="mr-2">
                                {{ order.take_away ? 'SI' : 'NO' }}
                              </label>
                              <input
                                type="checkbox"
                                v-model="order.take_away"
                                @click="confirmUpdateTakeAway(order, index, 'take_away', !order.take_away)"
                                :id="'take-away-checkbox-' + order.id"
                                class="cursor-pointer"
                              />
                              <div v-if="loadingTakeAway && loadingTakeAwayIndex === index">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="none" stroke="#ffffff" stroke-dasharray="15" stroke-dashoffset="15" stroke-linecap="round" stroke-width="2" d="M12 3C16.9706 3 21 7.02944 21 12"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.3s" values="15;0"/><animateTransform attributeName="transform" dur="1.5s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12"/></path></svg>
                              </div>                    
                            </td>

                            <!-- <td class="px-4 py-2 border border-gray-600">{{ order.portions }}</td> -->
                            <td @click="startEditing(index, 'portions')" class="px-4 py-2 border border-gray-600">
                              <div :id="'portion-' + index" :class="{'portion': !isEditing(index, 'portions'), 'hidden': isEditing(index, 'portions') || (loading && loadingIndex === index)}">
                                {{ order.portions }}
                              </div>
                              <input v-show="isEditing(index, 'portions')" type="number" v-model="editedNumber" @blur="stopEditing(index, 'portions', order)" @keydown.enter="stopEditing(index, 'portions', order)" class="text-black w-[80px]">
                              <div v-if="loading && loadingIndex === index">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="none" stroke="#ffffff" stroke-dasharray="15" stroke-dashoffset="15" stroke-linecap="round" stroke-width="2" d="M12 3C16.9706 3 21 7.02944 21 12"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.3s" values="15;0"/><animateTransform attributeName="transform" dur="1.5s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12"/></path></svg>
                              </div>
                            </td>

                            <td @click="startEditing(index, 'batata')" class="px-4 py-2 border border-gray-600" v-if="$page.props.pastelitosEvent">
                              <div :id="'portion-' + index" :class="{'portion': !isEditing(index, 'batata'), 'hidden': isEditing(index, 'batata') || (loading && loadingIndex === index)}">
                                {{ order.batata }}
                              </div>
                              <input v-show="isEditing(index, 'batata')" type="number" v-model="editedNumber" @blur="stopEditing(index, 'batata', order)" @keydown.enter="stopEditing(index, 'batata', order)" class="text-black w-[80px]">
                              <div v-if="loading && loadingIndex === index">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="none" stroke="#ffffff" stroke-dasharray="15" stroke-dashoffset="15" stroke-linecap="round" stroke-width="2" d="M12 3C16.9706 3 21 7.02944 21 12"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.3s" values="15;0"/><animateTransform attributeName="transform" dur="1.5s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12"/></path></svg>
                              </div>
                            </td>

                            <td class="px-4 py-2 border border-gray-600 bg-indigo-500" v-if="$page.props.pastelitosEvent">{{ (order.portions + order.batata) / 2 }}</td>

                            <td class="px-4 py-2 border border-gray-600" v-if="order.amount">{{ '$' + order.amount }}</td>
                            <td class="px-4 py-2 border border-gray-600" v-else="order.user_id">-</td>

                            <td v-if="!$page.props.pastelitosEvent" class="px-4 py-2 border border-gray-600">{{ order.sauces }}</td>

                            <td v-if="order.client_observations" @click="editObservation(order)" class="border border-gray-600">
                              <div v-if="editMode && activeOrderId == order.id">
                                <input v-model="newObservation" v-show="!loadingObservation" @blur="saveObservation(order.id, index)" class="text-black placeholder-gray-300" placeholder="Observación..."/>
                                <div v-if="loadingObservation">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                                    <path fill="none" stroke="#ffffff" stroke-dasharray="15" stroke-dashoffset="15" stroke-linecap="round" stroke-width="2" d="M12 3C16.9706 3 21 7.02944 21 12"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.3s" values="15;0"/><animateTransform attributeName="transform" dur="1.5s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12"/></path>
                                  </svg>
                                </div>
                              </div>
                              <div v-for="observation in order.client_observations" class="w-52 h-full px-4 border border-gray-600">
                                <div class="flex items-center justify-between">
                                  <div>
                                    <div v-html="formatObservation(observation)"></div>
                                  </div>
                                  <div @click="deleteObservation(observation, order.id, index)" class="cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><path fill="#e11d48" d="m9.4 16.5l2.6-2.6l2.6 2.6l1.4-1.4l-2.6-2.6L16 9.9l-1.4-1.4l-2.6 2.6l-2.6-2.6L8 9.9l2.6 2.6L8 15.1zM7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21z"/></svg>
                                  </div>
                                </div> 
                              </div>
                            </td>
                            <td v-else class="px-4 py-2 border border-gray-600">-</td>


                            <td class="px-4 py-2 border border-gray-600">
                              <div class="w-20 overflow-x-auto">
                                {{ order.updated_at }}   
                              </div>
                              <div>
                                {{ order.last_edition }} 
                              </div>
                            </td>

                            <td @click="startEditing(index, 'money_collected')" class="px-4 py-2 border border-gray-600">
                              <div :id="'money_collected-' + index" :class="{'money_collected': !isEditing(index, 'money_collected'), 'hidden': isEditing(index, 'money_collected') || (loadingMoneyCollected && loadingMoneyCollectedIndex == index)}">
                                ${{ order.money_collected }}
                              </div>
                              <input v-show="isEditing(index, 'money_collected')" type="number" v-model="editedMoneyCollected" @blur="stopEditing(index, 'money_collected', order)" class="text-black w-20">
                              <div v-if="loadingMoneyCollected && loadingMoneyCollectedIndex == index">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="none" stroke="#ffffff" stroke-dasharray="15" stroke-dashoffset="15" stroke-linecap="round" stroke-width="2" d="M12 3C16.9706 3 21 7.02944 21 12"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.3s" values="15;0"/><animateTransform attributeName="transform" dur="1.5s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12"/></path></svg>
                              </div>
                            </td>

                            <td class="px-4 py-2 border border-gray-600">${{ order.to_collect }}</td>

                            <td class="px-4 py-2 border border-gray-600">
                              <label :for="'mp-checkbox-' + order.id" class="mr-2">
                                {{ order.mp ? 'SI' : 'NO' }}
                              </label>
                              <input
                                type="checkbox"
                                v-model="order.mp"
                                @click="confirmUpdateMP(order, index, 'mp', !order.mp)"
                                :id="'mp-checkbox-' + order.id"
                                class="cursor-pointer"
                              />
                              <div v-if="loadingMP && loadingMPIndex === index">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="none" stroke="#ffffff" stroke-dasharray="15" stroke-dashoffset="15" stroke-linecap="round" stroke-width="2" d="M12 3C16.9706 3 21 7.02944 21 12"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.3s" values="15;0"/><animateTransform attributeName="transform" dur="1.5s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12"/></path></svg>
                              </div>                    
                            </td>
                            <td class="border border-gray-600">
                              <td class="border border-gray-600" v-if="$page.props.userRoles.includes('Admin', 'Logistica') || $page.props.userRoles.includes('Logistica')">
                                <input type="checkbox" class="checkbox w-9 h-9">
                              </td>
                              <td v-if="!order.user_id" @click="assignMeOrder(order.id, order.name, order.last_name)" class="px-4 py-2 cursor-pointer" style="background-color: #fde68a;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 128 128"><linearGradient id="IconifyId18f1931b6356e451c14" x1="85.143" x2="85.701" y1="31.138" y2="2.673" gradientTransform="matrix(1 0 0 -1 0 128)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#00BFA5"/><stop offset=".47" stop-color="#00B29A"/><stop offset="1" stop-color="#009E89"/></linearGradient><path fill="url(#IconifyId18f1931b6356e451c14)" d="M121.39 95.11c-19.84 0-59.38 10.01-74.61 28.89H124V95.13c-.87-.01-1.74-.02-2.61-.02"/><linearGradient id="IconifyId18f1931b6356e451c15" x1="75.223" x2="88.207" y1="16.389" y2="10.353" gradientTransform="matrix(1 0 0 -1 0 128)" gradientUnits="userSpaceOnUse"><stop offset=".197" stop-color="#262626"/><stop offset="1" stop-color="#262626" stop-opacity="0"/></linearGradient><path fill="url(#IconifyId18f1931b6356e451c15)" d="M95.92 98.57c-14.56 4.01-28.72 7.54-39.97 16.58c-1.02 3.15-2.06 6.36-2.85 8.85h29.32z" opacity=".35"/><path fill="#99674F" d="M104.38 75.85v18.58c0 8.24 6.67 14.94 14.86 14.94c0 0 4.27-.03 4.75-.08V75.85zm16.5-64.75H70.82c-10.49 0-19.08 9.15-19.08 20.32s8.59 20.32 19.08 20.32h50.06z"/><path fill="#BA8D68" d="M61.29 11.85c.66 22.24 7.37 42.68 18.9 57.54c10.77 13.89 25.09 21.85 39.3 21.85c1.51 0 3.01-.1 4.51-.27V4H71.58L61.36 5c-.13 2.56-.15 4.18-.07 6.85"/><path fill="#5D4037" d="M104.54 59.65c-3.26-1.94-6.59 1.03-5.24 3.99c1.33 2.91 11.48 9.66 20.25 9.66c1.46 0 2.96-.2 4.45-.53V62.02c-7.33.53-15.92-.26-19.46-2.37"/><path fill="#99674F" d="M113.19 45.1c-.19.02-.39.07-.57.15c-1.14.46-1.77 1.65-1.23 2.91c.54 1.26 3.05 4.8 8.1 4.8c1.83 0 3.32-.47 4.51-1.12V45.1z"/><ellipse cx="90.21" cy="28.78" fill="#49362E" rx="8.78" ry="9.09"/><path fill="#613E31" d="M80.25 16.99c4.15-1.77 8.25-2.76 12.81-2.15c2.08.28 4.09.89 6.01 1.71c1.49.63 3.16 1.16 4.4-.28c1.51-1.75.17-3.66-1.13-4.99c-1.57-1.61-3.54-2.82-5.63-3.63c-4.75-1.84-10.36-1.61-14.88.79c-1.96 1.04-4.12 2.52-5.21 4.53c-1.24 2.31 1.15 5.03 3.63 4.02"/><linearGradient id="IconifyId18f1931b6356e451c16" x1="90.591" x2="97.364" y1="52.209" y2="54.662" gradientTransform="matrix(1 0 0 -1 0 128)" gradientUnits="userSpaceOnUse"><stop offset=".197" stop-color="#262626"/><stop offset="1" stop-color="#262626" stop-opacity="0"/></linearGradient><path fill="url(#IconifyId18f1931b6356e451c16)" d="M94.94 69.13c-3.31-5.56-7.46-3.8-9.82-2.62c-2.35 1.18-1.84 6.85-1.84 6.85c4.25 4.67 8.92 8.53 13.85 11.46c-2.7-8.32.18-11.72-2.19-15.69" opacity=".35"/><linearGradient id="IconifyId18f1931b6356e451c17" x1="68.641" x2="32.502" y1="10.794" y2="12.469" gradientTransform="matrix(1 0 0 -1 0 128)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#00BFA5"/><stop offset=".47" stop-color="#00B29A"/><stop offset="1" stop-color="#009E89"/></linearGradient><path fill="url(#IconifyId18f1931b6356e451c17)" d="M66.76 116.69c-3.4-3.06-25.54-9.18-25.54-9.18c-.83-.33-1.62-.48-2.36-.48c-3.24 0-5.57 2.82-7.18 5.07l-6.3 11.9h42.35c.83-2.78 1.34-5.23-.97-7.31"/><linearGradient id="IconifyId18f1931b6356e451c18" x1="87.379" x2="46.077" y1="60.974" y2="14.648" gradientTransform="matrix(1 0 0 -1 0 128)" gradientUnits="userSpaceOnUse"><stop offset=".5" stop-color="#BA8D68"/><stop offset="1" stop-color="#A47B62"/></linearGradient><path fill="url(#IconifyId18f1931b6356e451c18)" d="M56.12 119.35c14.59.56 19.9-10 20.99-19.97c.63-5.76-.32-11.23-.32-11.23s7.37-3.97 12.69-13.62c1.19-2.17 1.7-5.73-.4-7.87c-2.2-2.24-6.29-2.95-9.98 1.2c-4.42 4.64-6.63 6.89-14.72 10.97c-6.59 3.33-15.88 4.24-22.13 10.24c-12.27 11.77-1.68 29.69 13.87 30.28"/><path fill="#91674D" d="M58.6 96.6c-1.12-4.98-3.83-7.91-7.89-9.08c-3-.86-4.99-.82-1.44.92c3.84 1.88 6.05 4.97 6.89 8.71c.99 4.39-1.1 7.37-3.6 8.37c-1.42.57-3.5.63-4.53-1.17c-1.82-3.17 1.59-4.96 1.6-4.96a1.25 1.25 0 1 0-1.01-2.29c-.11.05-2.49 1.31-3.52 3.74c-1.02 2.4.17 7.54 5.71 7.54c.87 0 1.8-.12 2.68-.54c6.56-3.06 5.58-9.2 5.11-11.24"/><path fill="#91674D" d="M68.86 94.03c-1.12-4.98-3.83-7.91-7.89-9.08c-3-.86-4.99-.82-1.44.92c3.84 1.88 6.05 4.97 6.89 8.71c.99 4.39-1.1 7.37-3.6 8.37c-1.42.57-3.5.63-4.53-1.17c-.03-.05-.05-.1-.08-.15l-1.6 2.48c.97 1 2.41 1.7 4.45 1.7c.87 0 1.8-.12 2.68-.54c6.56-3.06 5.58-9.2 5.12-11.24"/><path fill="#91674D" d="M77.52 90.72c-1.12-4.98-3.83-7.91-7.89-9.08c-3-.86-5-.82-1.44.92c3.84 1.88 6.05 4.97 6.89 8.71c.99 4.39-1.1 7.37-3.6 8.37c-1.14.46-2.69.57-3.8-.33c-.33.64-.81 1.57-1.22 2.4c.86.49 1.94.79 3.27.79c.87 0 1.8-.12 2.68-.54c6.56-3.06 5.57-9.2 5.11-11.24"/><linearGradient id="IconifyId18f1931b6356e451c19" x1="64.621" x2="79.094" y1="25.602" y2="25.602" gradientTransform="matrix(1 0 0 -1 0 128)" gradientUnits="userSpaceOnUse"><stop offset=".5" stop-color="#BA8D68"/><stop offset="1" stop-color="#A47B62"/></linearGradient><path fill="url(#IconifyId18f1931b6356e451c19)" d="M78.22 98.5c1.88 2.95.79 7.36-3.92 9.35c-4.03 1.71-7.22.86-8.68-1.27c-1.97-2.89-1.04-7.18 2.8-9.27s8.04-1.57 9.8 1.19"/><path fill="#91674D" d="M78.89 102.8c-.48 2.07-1.74 4.07-3.63 5.39c-.94.66-2.02 1.13-3.16 1.42c-1.14.26-2.34.31-3.55.13c-1.19-.22-2.44-.67-3.44-1.74c-.24-.26-.48-.61-.63-.91c-.12-.26-.25-.52-.36-.79c-.21-.55-.41-1.11-.5-1.71c-.22-1.18-.11-2.5.42-3.6a5.102 5.102 0 0 1 2.4-2.41c-.45 1.02-.8 1.97-.88 2.88c-.09.9.04 1.76.32 2.6c.14.42.31.84.5 1.26c.09.21.21.42.31.63c.08.17.15.25.25.39c.43.48 1.22.88 2.06 1.07c.85.21 1.79.26 2.7.13c.93-.09 1.84-.36 2.7-.77c1.78-.8 3.28-2.22 4.49-3.97"/><path fill="#543930" d="M71.58 4c-.1.37-.2.75-.3 1.13a358.8 358.8 0 0 0-1.37 5.44c-.13.5-.25 1-.38 1.51c0 .02-.01.04-.01.06c-.51 2.07-1.01 4.15-1.49 6.16c-.13.55-.26 1.08-.38 1.6c-.17.72-.34 1.43-.5 2.12c-.01.03-.01.06-.02.09c-.1.45-.21.9-.31 1.33c-.07.29-.13.58-.2.86c-.09.4-.18.79-.27 1.18c-.06.25-.12.5-.17.74c-.09.39-.18.78-.27 1.15c-.01.06-.02.12-.03.17c-.08.35-.16.68-.23 1.01c-.15.63-.28 1.23-.41 1.79c-.15.67-.29 1.28-.41 1.83c-.1.4-.18.76-.25 1.09c0 .02-.01.04-.01.06c-.14.6-.97.67-1.19.09c-1.08-2.73-3.02-7.82-4.14-10.76l-.43-1.12l-.44-1.15S57.17 13.69 57.05 4z"/><radialGradient id="IconifyId18f1931b6356e451c20" cx="154.72" cy="130.707" r="101.644" gradientTransform="matrix(1 0 0 -1.1282 0 144.757)" gradientUnits="userSpaceOnUse"><stop offset=".867" stop-color="#6D4C41" stop-opacity="0"/><stop offset="1" stop-color="#6D4C41"/></radialGradient><path fill="url(#IconifyId18f1931b6356e451c20)" d="M57.05 4h14.52c-.09.37-.19.75-.29 1.13a358.8 358.8 0 0 0-1.37 5.44c-.13.5-.25 1-.38 1.51c0 .02-.01.04-.01.06c-.51 2.07-1.01 4.15-1.49 6.16c-.13.55-.26 1.08-.38 1.6c-.17.72-.34 1.43-.5 2.12c-.01.03-.01.06-.02.09c-.1.45-.21.9-.31 1.33c-.07.29-.13.58-.2.86c-.09.4-.18.79-.27 1.18c-.06.25-.12.5-.17.74c-.09.39-.18.78-.27 1.15c-.01.06-.02.12-.03.17c-.08.35-.16.68-.23 1.01c-.15.63-.28 1.23-.41 1.79c-.15.67-.29 1.28-.41 1.83c-.1.4-.18.76-.25 1.09c-.13.6-.96.66-1.18.09l-4.59-11.82l-.44-1.15S57.17 13.69 57.05 4"/><path fill="none" stroke="#B0BEC5" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="4" d="M19.2 33.14c0 32.01 19.62 42.4 19.62 42.4"/><path fill="#B0BEC5" d="M41.14 66.27L30.91 77.86l13.54 2.97z"/></svg>
                              </td>
                              <td @click.prevent="destroy(order.id, order.name, order.last_name)" class="border border-gray-600 h-9 cursor-pointer" style="background-color: #dc2626;" v-if="$page.props.userRoles.includes('Admin', 'Logistica') || $page.props.userRoles.includes('Logistica')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="#ffffff" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zM9 17h2V8H9zm4 0h2V8h-2zM7 6v13z"/></svg>
                              </td>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div v-if="!user_has_orders && list_type !== 'general'" class="flex mt-4">
                  <h1 class="px-4 py-2 border border-gray-600 text-[30px]">No tenes clientes en tu lista. Ponete las pilas porfa.</h1>
                  <div class="border border-red-500">
                    <img src="../../img/cosas/sin-lista.jpg" alt="Sos ese">
                    <p class="text-center text-[20px]">{{ user_auth_name }}</p>
                  </div>
                </div>

                <div v-if="orders.length == 0 && list_type === 'my_list' && user_has_orders" class="mt-4">
                  <p class="px-4 py-2 text-[30px] text-red-400">No existen ordenes con estos datos</p>
                    <img src="../../img/cosas/busqueda-erronea-mi-lista.jpg" alt="Sos ese buscando">
                </div>

                <div v-if="orders.length == 0 && list_type === 'general'" class="mt-4">
                  <p class="px-4 py-2 text-[30px] text-red-400">No existen ordenes con estos datos</p>
                    <img src="../../img/cosas/busqueda-erronea.jpg" alt="Sos ese buscando">
                </div>
            </div>

            <section class="mt-4 ml-2 md:flex md:space-x-5">
              <div class="flex items-center space-x-2">
                <div class="bg-lime-600 w-4 h-4"></div>
                <p>100% cobrado</p>
              </div>
              <div class="flex items-center space-x-2">
                <div class="bg-orange-600 w-4 h-4"></div>
                <p>Falta cobrar</p>
              </div>
              <div class="flex items-center space-x-2">
                <div class="bg-red-600 w-4 h-4"></div>
                <p>Devolver dinero</p>
              </div>
            </section>
        </div>
    </div>
    <FormOrderModal v-if="isFormModalOpen" :closeModal="closeEditModal"/>
    <AssignOrderModal v-if="isAssignModalOpen" :closeModal="closeAssignModal" :rovers="rovers" :idsTildados="idsTildados" :nombresTildados="nombresTildados"/>
</template>

<style scoped>
body {
  overflow-y: hidden;
  background-color: #1f2937;
}

.table-scroll {
  position: relative;
  width: calc(100% - 8px);
  z-index: 1;
  margin: auto;
  overflow: auto;
  margin-left: 8px;
}
@media (max-width: 767px) {
  .table-scroll {
  height: 60vh;
  }
}
@media (min-width: 768px) {
  .table-scroll {
  height: 75vh;
  }
}

.table-scroll table {
  width: 100%;
  min-width: 1280px;
  margin: auto;
  border-collapse: separate;
  border-spacing: 0;
}
.table-wrap {
  position: relative;
}
.table-scroll th,
.table-scroll td {
  padding: 5px 10px;
  /* border: 1px solid #000;
  background: #fff; */
  vertical-align: top;
}
.table-scroll thead th {
  background: #161616;
  color: #fff;
  position: -webkit-sticky;
  position: sticky;
  top: 0;
}

.table-scroll tfoot,
.table-scroll tfoot th,
.table-scroll tfoot td {
  position: -webkit-sticky;
  position: sticky;
  bottom: 0;
  background: #202020;
  color: #fff;
  z-index:4;
}

th:nth-child(-n + 3), td:nth-child(-n + 3) {
    position: -webkit-sticky;
    position: sticky;
    left: 0;
    z-index: 3; /* Modificado de 2 a 3 */
    background: #383737;
}
thead th:nth-child(-n + 3),
tfoot th:first-child {
        z-index: 5;
}
</style>

<script setup>
import { defineProps } from 'vue';
import { ref, watch, onMounted, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';
import FormOrderModal from './NewOrder.vue';
import AssignOrderModal from './AssignOrderModal.vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import 'animate.css';
import { acountants } from '../composables/accountants';
import { useMassAssignButton  } from '../composables/useMassAssignButton';

const props = defineProps({
    orders: {
        type: Object,
    },
    rovers: {
        type: Object,
    },
    user_auth_name: String,
    list_type: String,
    user_has_orders: Boolean
});

const {
      totalPortions,
      totalBatata,
      totalSalesMoney,
      totalMoneyCollected,
      totalSauces
    } = acountants(props);

const {
  checkboxes,
  boton,
  boton_desk,
  isAssignModalOpen,
  openAssignModal,
  closeAssignModal,
  idsTildados,
  nombresTildados
} = useMassAssignButton(props.orders);

// BUSCAR ORDENES
const search = ref(null);
watch(search, value => {
    if (props.list_type === 'general') {
      router.get('/', {search: value}, 
        {
            preserveState: true,
            replace: true,
        }
      );
    }

    if (props.list_type === 'my_list') {
      router.get('/my-list', {search: value}, 
        {
            preserveState: true,
            replace: true,
        }
      );
    }
});
// FIN BUSCAR ORDENES

const formatObservation = (observation) => {
  // Asegúrate de tener esta función en tu código
  function nl2br(str) {
      return str.replace(/(?:\r\n|\r|\n)/g, '<br>');
  }

  // Usa nl2br y escape para evitar inyecciones de código
  return nl2br(observation.observation);
}

// AGREGAR OBSERVACIONES
const editMode = ref(false);
const activeOrderId = ref(null);
const newObservation = ref('');
const loadingObservation = ref(false);

const editObservation = (order) => {
  // Habilita el modo de edición y configura la orden actual
  activeOrderId.value = order.id;
  editMode.value = true;
  newObservation.value = order.observation;
};

const saveObservation = async (order_id, index) => {
  try {
    loadingObservation.value = true;

    const dataToUpdate = {
      observation: newObservation.value,
    };

    // Realiza la solicitud POST para guardar la nueva observación
    const response = await axios.post(`/order/${order_id}/addObservation`, dataToUpdate);

    props.orders[index] = response.data.order;

    // Desactiva el modo de edición
    activeOrderId.value = null;
    editMode.value = false;
  } catch (error) {
    console.error('Error al realizar la operación:', error);
  } finally {
    loadingObservation.value = false;
  }
};
// FIN AGREGAR OBSERVACIONES


// ELIMINAR OBSERVACION
const deleteObservation = async (observation, order_id, index) => {
  if(confirm(`¿Deseas eliminar la observación: ${observation.observation}?`)){
    try {
      loadingObservation.value = true;

      // Realiza la solicitud POST para guardar la nueva observación
      const response = await axios.delete(`/order/${order_id}/${observation.id}/deleteObservation`);

      props.orders[index] = response.data.order;
    } catch (error) {
      console.error('Error al eliminar observación:', error);
    } finally {
      loadingObservation.value = false;
    }
    }
}
;
// FIN ELIMINAR OBSERVACION

// EDITAR NOMBRE
const editingNameIndex = ref(null);
const editedName = ref(null);
const loadingName = ref(false);
const loadingNameIndex = ref(null);

function updateName(order_id, index, field) {
  loadingName.value = true;
  loadingNameIndex.value = index;

  const dataToUpdate = {
          [field]: editedName.value,
        };

  updateClient(order_id, index, field, dataToUpdate);
}
// FIN EDITAR NOMBRE

// EDITAR APELLIDO
const editingLastNameIndex = ref(null);
const editedLastName = ref(null);
const loadingLastName = ref(false);
const loadingLastNameIndex = ref(null);

function updateLastName(order_id, index, field) {
  loadingLastName.value = true;
  loadingLastNameIndex.value = index;

  const dataToUpdate = {
          [field]: editedLastName.value,
        };

  updateClient(order_id, index, field, dataToUpdate);
}
// FIN EDITAR APELLIDO

// EDITAR NUMERO DE TELEFONO
const editingPhoneNumberIndex = ref(null);
const editedPhoneNumber = ref(null);
const loadingPhoneNumber = ref(false);
const loadingPhoneNumberIndex = ref(null);

function updatePhoneNumber(order_id, index, field) {
  loadingPhoneNumber.value = true;
  loadingPhoneNumberIndex.value = index;

  const dataToUpdate = {
          [field]: editedPhoneNumber.value,
        };

  updateClient(order_id, index, field, dataToUpdate);
}
// FIN EDITAR NUMERO DE TELEFONO

// EDITAR DIRECCION
const editingDirection = ref(null);
const editedDirection = ref(null);
const loadingDirection= ref(false);
const loadingDirectionIndex = ref(null);

function updateDirection(order_id, index, field) {
  loadingDirection.value = true;
  loadingDirectionIndex.value = index;

  const dataToUpdate = {
          [field]: editedDirection.value,
        };

  updateClient(order_id, index, field, dataToUpdate);
}
// FIN EDITAR DIRECCION

// EDITAR CODIGO POSTAL
const editingPostalCode = ref(null);
const editedPostalCode = ref(null);
const loadingPostalCode= ref(false);
const loadingPostalCodeIndex = ref(null);

function updatePostalCode(order_id, index, field) {
  loadingPostalCode.value = true;
  loadingPostalCodeIndex.value = index;

  const dataToUpdate = {
          [field]: editedPostalCode.value,
        };

  updateClient(order_id, index, field, dataToUpdate);
}
// FIN CODIGO POSTAL

// EDITAR PORCIONES, DELIVERY
const editingIndex = ref(null);
const editedNumber = ref(null);
const loading = ref(false);
const loadingIndex = ref(null);

function updatePortions(orderId, index, field) {
  loading.value = true;
  loadingIndex.value = index;

  const dataToUpdate = {
          [field]: editedNumber.value,
        };
  updateOrder(orderId, index, field, dataToUpdate);
}

const isEditing = (index, field) => {
  return editingIndex.value === index + '-' + field;
};
// FIN EDITAR PORCIONES

// EDITAR DINERO COBRADO
const editedMoneyCollected  = ref(false);
const loadingMoneyCollected = ref(false);
const loadingMoneyCollectedIndex = ref(null);

const updateMoneyCollected = (order, index, field) => {
      loadingMoneyCollected.value = true;
      loadingMoneyCollectedIndex.value = index;

      const dataToUpdate = {
          [field]: editedMoneyCollected.value,
      };
      updateOrder(order.id, index, field, dataToUpdate);
}
// FIN EDITAR DINERO COBRADO


// EDITAR MERCADO PAGO
const loadingMP = ref(false);
const loadingMPIndex = ref(null);

const confirmUpdateMP = (order, index, field, value) => {
    const confirmationText = `¿Confirmas que ${order.name} ${order.last_name}${value ? "" : " NO"} paga con mercado pago?`;

    if (!confirm(confirmationText)) {
      // Si se cancela el confirm, revertir el cambio en el checkbox
      // order.take_away = !value;
      event.preventDefault();
    } else {
      loadingMP.value = true;
      loadingMPIndex.value = index;

      const dataToUpdate = {
          [field]: value,
      };
      updateOrder(order.id, index, field, dataToUpdate);
    }
}
// FIN EDITAR MERCADO PAGO

// EDITAR DELIVERY
const loadingTakeAway = ref(false);
const loadingTakeAwayIndex = ref(null);

const confirmUpdateTakeAway = (order, index, field, value) => {
    const confirmationText = `¿Confirmas que ${order.name} ${order.last_name} ${value ? "SI" : "NO"} quiere retirar su orden?`;

    if (!confirm(confirmationText)) {
      // Si se cancela el confirm, revertir el cambio en el checkbox
      // order.take_away = !value;
      event.preventDefault();
    } else {
      loadingTakeAway.value = true;
      loadingTakeAwayIndex.value = index;

      const dataToUpdate = {
          [field]: value,
      };
      updateOrder(order.id, index, field, dataToUpdate);
    }
}
// FIN EDITAR DELIVERY

// Iniciar edicion de celda
const startEditing = (index, field) => {
  editingIndex.value = index + '-' + field;
  editedNumber.value = props.orders[index][field];
  editedMoneyCollected.value = props.orders[index][field];
  editedLastName.value = props.orders[index][field];
  editedName.value = props.orders[index][field];
  editedPhoneNumber.value = props.orders[index][field];
  editedDirection.value = props.orders[index][field];
  editedPostalCode.value = props.orders[index][field];
};

const stopEditing = (index, field, order) => {
  if (field == 'portions') {
    updatePortions(order.id, index, field);
    editingIndex.value = null;
  }

  if (field == 'batata') {
    updatePortions(order.id, index, field);
    editingIndex.value = null;
  }

  if (field == 'money_collected') {
    updateMoneyCollected(order, index, field);
    editingIndex.value = null;
  }

  if (field == 'name') {
    updateName(order.id, index, field);
    editingIndex.value = null;
  }

  if (field == 'last_name') {
    updateLastName(order.id, index, field);
    editingIndex.value = null;
  }

  if (field == 'phone_number') {
    updatePhoneNumber(order.id, index, field);
    editingIndex.value = null;
  }

  if (field == 'direction') {
    updateDirection(order.id, index, field);
    editingIndex.value = null;
  }

  if (field == 'postal_code') {
    updatePostalCode(order.id, index, field);
    editingIndex.value = null;
  }
};
// FIN Iniciar edicion de celda

// FUNCION MAIN PARA EDITAR ORDENES
async function updateOrder(orderId, index, field, dataToUpdate) {
    try {
      if (dataToUpdate[field] != props.orders[index][field]) {
        const response = await axios.put(`/order/${orderId}/edit/${field}`, dataToUpdate);
  
        props.orders[index] = response.data.order;
  
        editingIndex.value = null;
  
        await toast.success(`Orden de ${props.orders[index].name} editada con éxito!`, { autoClose: 4000 });
      }
    } catch (error) {
        console.error('Error al realizar la operación:', error);
        await toast.error('Error al editar orden!');
    } finally {
    loading.value = false;
    loadingIndex.value = null;
    loadingTakeAway.value = false;
    loadingTakeAwayIndex.value = null;
    loadingMoneyCollected.value = false;
    loadingMoneyCollectedIndex.value = null;
    loadingMP.value = false;
    loadingMPIndex.value = null;
    }
}
// FIN FUNCION MAIN PARA EDITAR ORDENES


// FUNCION MAIN PARA EDITAR CLIENTES
async function updateClient(order_id, index, field, dataToUpdate) {
    try {
      if (dataToUpdate[field] != props.orders[index][field]) {
        const response = await axios.put(`/client/${order_id}/edit/${field}`, dataToUpdate);
  
        props.orders[index] = response.data.order;
  
        editingIndex.value = null;
        await toast.success(`Cliente ${props.orders[index].name} editado con éxito!`, { autoClose: 4000 });
      }
    } catch (error) {
        console.error('Error al realizar la operación:', error);
        await toast.error('Error al editar cliente!');
    } finally {
    loadingLastName.value = false;
    loadingLastNameIndex.value = null;
    loadingName.value = null;
    loadingNameIndex.value = null;
    loadingPhoneNumber.value = null;
    loadingPhoneNumberIndex.value = null;
    loadingDirection.value = null;
    loadingDirectionIndex.value = null;
    loadingPostalCode.value = null;
    loadingPostalCodeIndex.value = null;
    }
}
// FIN FUNCION MAIN PARA EDITAR ORDENES

// ELIMINAR ORDEN
async function destroy(order_id, name, last_name) {
    try {
        if (confirm(`¿Estás seguro que queres borrar la orden de ${name} ${last_name}?`)) {
          await router.delete(`/order/${order_id}/delete`);
          await toast.success(`Orden de ${name} eliminada con éxito!`);
        }
    } catch (error) {
        console.error('Error al realizar la operación:', error);
        await toast.error('Error al eliminar orden!');
    }
}
// FIN ELIMINAR ORDEN

// NUEVA ORDEN
const isFormModalOpen = ref(false);
const openNewOrder = () => {
    isFormModalOpen.value = true;
};
const closeEditModal = () => {
    isFormModalOpen.value = false;
};
// FIN NUEVA ORDEN

async function assignMeOrder(order_id, name, last_name) {
  try {
    if (confirm(`¿Queres asignarte la orden de ${name} ${last_name}?`)) {
      await router.put(`/order/${order_id}/assignMeOrder`);
      await toast.success(`Orden de ${name} ${last_name} asignada con éxito!`);
    }
  } catch (error) {
    console.error('Error al realizar la operación:', error);
    await toast.error('Error al asignarte orden!');
  }
}
</script>